<?php


namespace App\Domains\Product\Http\Controllers\Api;

use App\Domains\Applicability\Models\Applicability;
use App\Domains\Category\Models\Category;
use App\Domains\Currency\Models\Currency;
use App\Domains\Product\Models\Product;
use App\Domains\Product\Models\ProductApplicability;
use App\Domains\Product\Models\ProductCategory;
use App\Domains\Product\Models\ProductsOption;
use App\Domains\Product\Models\ProductsOptionsValue;
use App\Domains\Product\Models\ProductsProperty;
use App\Domains\Product\Models\ProductsTranslation;
use App\Domains\Product\Models\ProductsVariant;
use App\Domains\Product\Models\RefChar;
use App\Domains\Product\Models\RefCharsValue;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Orchid\Layouts\Product\ProductOptionsRows;
use Database\Factories\ProductFactory;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductControllers extends BaseController
{
    private $langs = [];
    private $applicability = [];
    private $course_id = '';
    private float $min_price = 999999;
    private float $max_price = 0;

    public function import(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (!empty($data)) {
            $sourceFileName = 'products.json';
            $fileFullPath = 'app/tmp'; // Соответствует storage/app/public/

            Storage::disk('local')->makeDirectory('tmp');

            $file = storage_path($fileFullPath . '/' . $sourceFileName);

            if (file_exists($file)) {
                unlink($file);
            }

            file_put_contents($file, $request->getContent());
        }

        $rules = [
            'products' => 'required|array|min:1',
            'products.*.name' => 'required|max:255',
            'products.*.description' => 'required',
            'products.*.article' => 'required|max:255',
            'products.*.category_id' => 'required|array|min:1',
            'products.*.category_id.*.external_id' => 'required|max:36', // |exists:categories,external_id
            'products.*.external_id' => 'required|max:36',
            'products.*.variants' => 'required|array|min:1',
            'products.*.variants.*.external_id' => 'required|max:36',
            'products.*.variants.*.name' => 'required|max:255',
            'products.*.variants.*.code' => 'required|max:255',
            // 'products.*.variants.*.price' => 'required|regex:/^\d*(\.\d{2})?$/',
            'products.*.variants.*.price' => 'required',
            'products.*.variants.*.unit' => 'required',
            'products.*.variants.*.quantity' => 'required|integer',
            'products.*.variants.*.currency' => 'required|min:3|max:3',
            'products.*.variants.*.options' => 'required|array|min:1',
            'products.*.variants.*.options.*.external_id' => 'required|max:36|exists:ref_chars_values,external_id',
            'products.*.chars' => 'nullable|array|min:1',
            'products.*.chars.*.external_id' => 'required|max:36|exists:ref_chars_values,external_id'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $this->setLangs();

        foreach ($data['products'] as $item) {
            $product = Product::updateOrCreate([
                'external_id' => $item['external_id']
            ], [
                'slug' => Str::slug($item['name']),
                'article' => $item['article'],
                'active' => ($item['active']) ? 1 : 0,
                'max_price' => 0,
                'min_price' => 0,
                'sort' => 100
            ]);

            $this->course_id = $product->id;

            // обновление переводов
            $this->setProductTrans($item['name'], $item['description']);

            // обновление категорий
            $this->setProductToCategory($item['category_id']);

            // обновление свойств
            $this->setProductToChars($item['chars']);

            // обновление опций
            $item['options'] = collect($item['variants'])->map(function ($arr, $key) {
                return $arr['options'];
            })->toArray();

            $this->setProductToOptions($item['options']);

            // обновление вариаций
            $this->setProductToVariants($item['variants']);

            $this->setProductToApplicability();
         
            $product->min_price = $this->min_price;
            $product->max_price = $this->max_price;
            $product->save();
            $this->max_price = 0;
            $this->min_price = 0;
        }

        return $this->sendResponse([], 'message');
    }

    /*
    *
    * Создаем список языков в приватный массив langs
    *
    **/

    private function setLangs()
    {
        foreach (LaravelLocalization::getSupportedLocales() as $key => $item) {
            $this->langs[] = $key;
        }
    }

    /*
    * 
    * Присваеваем продукт название
    *
    * @params integer $course_id
    * @params string $name
    *
    */

    private function setProductTrans($name, $description)
    {
        foreach ($this->langs as $lang) {
            switch ($lang) {
                case 'ru':
                    ProductsTranslation::updateOrCreate([
                        'course_id' => $this->course_id,
                        'locale' => $lang
                    ], [
                        'name' => $name,
                        'description' => $description
                    ]);
                    break;
                default:
                    $productTrans = ProductsTranslation::where('course_id', $this->course_id)->where('locale', $lang)->get();
                    switch ($productTrans->count()) {
                        case '0':
                            ProductsTranslation::create([
                                'course_id' => $this->course_id,
                                'locale' => $lang,
                                'name' => $name,
                                'description' => $description
                            ]);
                            break;
                    }
                    break;
            }
        }
    }

    /*
    * 
    * Присваеваем продукт к категориям
    *
    * @params private integer $course_id
    * @params array $categories
    *
    */

    private function setProductToCategory($categories)
    {
        ProductCategory::where('course_id', $this->course_id)->delete();
        
    
        foreach ($categories as $key => $category) {
            $rsCategory = Category::where('external_id', $category['external_id'])->first();
            if ($rsCategory) {
                $category_id = $rsCategory->id;
                if (end($categories) === $category) {
                    ProductCategory::updateOrCreate([
                        'course_id' => $this->course_id,
                        'category_id' => $category_id,
                    ], [
                        'main' => 1,
                    ]);
                } else {
                    ProductCategory::updateOrCreate([
                        'course_id' => $this->course_id,
                        'category_id' => $category_id,
                    ], [
                        'main' => 0,
                    ]);
                }
            }
        }
    }


    /*
    * 
    * Присваеваем продукт к Варианты
    *
    * @params private integer $course_id
    * @params array $variants
    */

    private function setProductToVariants($variants)
    {
        $iteration = 0;
        foreach ($variants as $key=>$variant) {
            $iteration++;

            switch($variant['active']){
                case true:
                    $isMaster = ($iteration == 1 ? 1 : 0);

                    $productsVariant = ProductsVariant::where('external_id', $variant['external_id'])->where('course_id', $this->course_id)->first();

                    if($productsVariant){
                        $productsVariant->update([
                            'name' => $variant['name'],
                            'price' => (float)$variant['price'],
                            'price_sale' => array_key_exists('price_sale', $variant) ? (float)$variant['price_sale'] : 0,
                            'code' => $variant['currency'],
                            'quantity' => $variant['quantity'],
                            'unit' => $variant['unit'],
                            'master' => $isMaster,
                            'options' => [],
                        ]);
                    }
                    else{
                        $productsVariant = ProductsVariant::create([
                            'external_id' => $variant['external_id'],
                            'course_id' => $this->course_id,
                            'name' => $variant['name'],
                            'price' => (float)$variant['price'],
                            'price_sale' => array_key_exists('price_sale', $variant) ? (float)$variant['price_sale'] : 0,
                            'code' => $variant['currency'],
                            'quantity' => $variant['quantity'],
                            'unit' => $variant['unit'],
                            'master' => $isMaster,
                            'options' => [],
                        ]);
                    }

                    $currency = Currency::where('code', $variant['currency'])->first();
                    if($variant['price'] >= 0){
                        $price = $variant['price'] * $currency->value;
                        if($this->min_price > $price){
                            $this->min_price = $price;
                        }
                        if($this->max_price < $price){
                            $this->max_price = $price;
                        }
                    }

                    if(array_key_exists('price_sale', $variant)){
                        if($variant['price_sale'] >= 0){
                            $price_sale = $variant['price_sale'] * $currency->value;
                            if($this->min_price > $price_sale){
                                $this->min_price = $price_sale;
                            }
                            if($this->max_price < $price_sale){
                                $this->max_price = $price_sale;
                            }
                        }
                    }
                    $json = [];
            
                    foreach($variant['options'] as $option){
                        $refCharsValue = RefCharsValue::where("external_id", $option['external_id'])->get();

                        $value = [];

                        foreach ($refCharsValue as $refCharValue) {
                            $slug = $refCharValue->chars->slug;

                            $productsOption = ProductsOption::where('ref_char_id', $refCharValue->char_id)
                                ->where('course_id', $this->course_id)->get()
                                ->first();

                            if ($productsOption) {
                                $productsOptionsValue = ProductsOptionsValue::where('products_option_id', $productsOption->id)
                                    ->where('ref_char_id', $refCharValue->char_id)
                                    ->where('ref_char_value_id', $refCharValue->id)
                                    ->where('locale', $refCharValue->locale)
                                    ->first();
                                $value[$productsOptionsValue->locale] = $productsOptionsValue->id;
                            }

                            $json[$slug] = $value;
                        }
                    }
                    $productsVariant->update(['options' => $json]);
                    break;
                case false:
                    ProductsVariant::where('external_id', $variant['external_id'])->delete();
                    break;
            }          
        }
    }

    /*
    *
    * Обновление опций
    *
    * @params private integer $course_id
    * @params array $chars
    */
    private function setProductToOptions($collect)
    {
        foreach ($collect as $chars) {
            foreach ($chars as $char) {
                $refCharsValue = RefCharsValue::where('external_id', $char['external_id'])->with('char')->get();
                foreach ($refCharsValue as $item) {
                    $this->setOption($item);
                }
            }
        }
    }

    /*
    *
    * Обновление характеристик
    *
    * @params private integer $course_id
    * @params array $chars
    */
    private function setProductToChars($chars)
    {
        $this->applicability = [];
        foreach ($chars as $char) {
            $refCharsValue = RefCharsValue::where('external_id', $char['external_id'])->with('char')->get();
        
            foreach ($refCharsValue as $item) {

                // создаем массив применимостей
                switch($item->char->slug){
                    case 'mesto-primeneniya':
                        $this->applicability[$item->external_id] = $item->external_id;
                        break;
                }
                if ($item->char->type != 'property') {
                    continue;
                }
                $this->setProperties($item);
            }
        }
    }

    /*
    *
    * Наполняем Опциями продукт
    *
    * @params private integer $course_id
    * @params RefCharsValue $option
    */

    private function setOption(RefCharsValue $option)
    {
        $productOption = ProductsOption::updateOrCreate([
            'course_id' => $this->course_id,
            'ref_char_id' => $option->char_id,
        ], []);

        ProductsOptionsValue::updateOrCreate([
            'products_option_id' => $productOption->id,
            'ref_char_id' => $option->char_id,
            'ref_char_value_id' => $option->id,
            'locale' => $option->locale
        ], []);
    }


    /*
    *
    * Наполняем характеристиками продукт
    *
    * @params private integer $course_id
    * @params RefCharsValue $properti
    */

    private function setProperties(RefCharsValue $properti)
    {
        ProductsProperty::updateOrCreate([
            'course_id' => $this->course_id,
            'ref_char_id' => $properti->char_id,
            'ref_char_value_id' => $properti->id,
            'locale' => $properti->locale
        ], []);
    }


    /*
    * 
    * Присваеваем продукт к применимостям 
    *
    * @params private integer $course_id
    * @params array $categories
    *
    */
    private function setProductToApplicability(){
        if($this->applicability){
            ProductApplicability::where('course_id', $this->course_id)->delete();
            foreach($this->applicability as $applicability){
                ProductApplicability::create([
                    'course_id' => $this->course_id,
                    'applicability_id' => Applicability::where('external_id', $applicability)->first()->id
                ]);
            }
        }
    }
}
