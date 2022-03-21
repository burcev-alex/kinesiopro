<?php
namespace App\Domains\Product\Services;

use App\Domains\Category\Models\Category;
use App\Domains\Product\Models\ProductApplicability;
use App\Domains\Product\Models\ProductCategory;
use App\Domains\Product\Models\ProductsImage;
use App\Domains\Product\Models\ProductsOption;
use App\Domains\Product\Models\ProductsOptionsValue;
use App\Domains\Product\Models\ProductsProperty;
use App\Domains\Product\Models\ProductsVariant;
use App\Domains\Product\Models\ProductsVariantsImage;
use App\Domains\Product\Models\RefCharsValue;
use App\Domains\Product\Services\ProductService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Log;
use Orchid\Attachment\Models\Attachment;

class ProductOrchidService extends ProductService
{

    protected $group = null;

    /**
     * Сохраняет личные поля модели
     *
     * @param  array $fields
     * @return self
     */
    public function save(array $fields): self
    {
        $this->model->fill($fields)->save();
        $this->saveMarkers($fields);
        return $this;
    }

    /**
     * Установка группы товаров
     *
     * @param ProductsGroup $group
     * @return self
     */
    // public function setGroup(ProductsGroup $group): self
    // {
    //     $this->group = $group;
    //     return $this;
    // }

    /**
     * Принимает двумерный массив локаль => поля и сохраняет каждую. 
     *
     * @param  mixed $fields
     * @return void
     */
    public function saveTranslations(array $fields)
    {
        foreach ($fields as $locale => $translation) {
            $this->saveTranslation($locale, $translation);
        }
        return $this;
    }


    /**
     * saveTranslation
     *
     * @param  string $locale
     * @param  array $translations
     * @return self
     */
    public function saveTranslation(string $locale, array $fields): self
    {
        $this->model->translations->where('locale', $locale)->first()
            ->fill($fields)->save();
        return $this;
    }

    public function saveCategories(array $categories){
        ProductCategory::where('course_id', $this->model->id)->delete();
        foreach($categories as $category_id){
            ProductCategory::updateOrCreate([
                'course_id' => $this->model->id,
                'category_id' => $category_id
            ],[
                'main' => 0
            ]);
        }
    }

    public function saveCategoryMain($category_main){
        ProductCategory::updateOrCreate([
            'course_id' => $this->model->id,
            'category_id' => $category_main
        ],[
            'main' => 1
        ]);
    }

    public function saveApplicabilities(array $applicabilities){
        ProductApplicability::where('course_id', $this->model->id)->delete();
        foreach($applicabilities as $applicabilies_id){
            ProductApplicability::updateOrCreate([
                'course_id' => $this->model->id,
                'applicability_id' => $applicabilies_id
            ],[]);
        }
    }


    public function saveProperties(array $properties, $overwrite = true)
    {
        if ($overwrite) {
            // найти все значения характеристик
            $arrPropertyValues = [];
            $resProductProperties = ProductsProperty::where('course_id', $this->model->id)->with('ref_char')->get();
            foreach ($resProductProperties as $propertyValue) {
                // если это изменения из группы , 
                // тогда НЕ редактировать поля Цена за пару и Размеры в ростовке
                if (! is_null($this->group)) {
                    if (! in_array($propertyValue->ref_char->slug, ['cvet'])) {
                        $arrPropertyValues[] = $propertyValue->ref_char_value_id;
                    }
                }
                else{
                    $arrPropertyValues[] = $propertyValue->ref_char_value_id;
                }
            }
            
            // найти пересечение и удалить те значения , которых нет в новом наборе
            foreach ($arrPropertyValues as $valueId) {
                if (! in_array($valueId, $properties)) {
                    $rsDeleteProperty = ProductsProperty::where('course_id', $this->model->id)->where('ref_char_value_id', $valueId)->get();
                    foreach ($rsDeleteProperty as $property) {
                        $property->delete();
                    }
                }
            }
        }

        foreach ($properties as $char_value) {
            $ref_char_value = RefCharsValue::find($char_value);
            ProductsProperty::updateOrCreate([
                'course_id' => $this->model->id,
                'ref_char_value_id' => $char_value
            ], [
                'ref_char_id' => $ref_char_value->char_id,
                'locale' => $ref_char_value->locale
            ]);

            $locales = RefCharsValue::where('locale', '!=', $ref_char_value->locale)
                ->distinct('locale')->get()->pluck('locale')->unique('locale');
            // Log::info($locales);
            $locales->each(function ($locale) use ($ref_char_value) {
                $ru_ref_char_value = RefCharsValue::where('slug', $ref_char_value->slug)->where('char_id', $ref_char_value->char_id)->where('locale', $locale)->first();
                if($ru_ref_char_value){
                    ProductsProperty::updateOrCreate([
                        'course_id' => $this->model->id,
                        'ref_char_value_id' => $ru_ref_char_value->id
                    ], [
                        'ref_char_id' => $ru_ref_char_value->char_id,
                        'locale' => $ru_ref_char_value->locale
                    ]);
                }
            });
        }
        return $this;
    }


    public function saveOptions(array $options)
    {
        // найти все значения опций
        // найти пересечение и удалить те значения , которых нет в новом наборе
        $resProductOptions = ProductsOption::where('course_id', $this->model->id)->with('values')->get();
        foreach($resProductOptions as $optionValues){
            foreach($optionValues->values as $optionValue){
                if(!in_array($optionValue->ref_char_value_id, $options)){
                    $rsDeleteOptionValue = ProductsOptionsValue::where('products_option_id', $optionValues->id)->where('ref_char_value_id', $optionValue->ref_char_value_id)->get();
                    foreach($rsDeleteOptionValue as $option){
                        $option->delete();
                    }
                }
            }
        }
        

        foreach ($options as $char_value) {
            $ref_char_value = RefCharsValue::find($char_value);
            $option = ProductsOption::updateOrCreate([
                'course_id' => $this->model->id,
                'ref_char_id' => $ref_char_value->char_id
            ]);

            $ov = ProductsOptionsValue::updateOrCreate([
                'products_option_id' => $option->id,
                'ref_char_value_id' => $ref_char_value->id
            ], [
                'ref_char_id' => $ref_char_value->char_id,
                'locale' => $ref_char_value->locale
            ]);

            $locales = RefCharsValue::where('locale', '!=', $ref_char_value->locale)
                ->distinct('locale')->get()->pluck('locale')->unique('locale');
            // Log::info($locales);

            $locales->each(function ($locale) use ($ref_char_value, $option) {
                $ru_ref_char_value = RefCharsValue::where('slug', $ref_char_value->slug)->where('char_id', $ref_char_value->char_id)->where('locale', $locale)->first();
                if($ru_ref_char_value){
                    ProductsOptionsValue::updateOrCreate([
                        'products_option_id' => $option->id,
                        'ref_char_id' => $ru_ref_char_value->char_id,
                        'ref_char_value_id' => $ru_ref_char_value->id,
                        'locale' => $ru_ref_char_value->locale
                    ]);
                }
            });
        }
        return $this;
    }

    public function saveImages(array $images)
    {
        if(!isset($images['anons'])) $images['anons'] = [];         
        if(!isset($images['least'])) $images['least'] = [];         
        
        $all_images = [...$images['anons'], ...$images['least']];

        $images_to_delete = ProductsImage::where('course_id', $this->model->id)->whereNotIn('attachment_id', $all_images)->get();

        switch($images_to_delete->count()){
            case '0':
                break;
            default:
                $images_to_delete->each->delete();
                break;
        }

        foreach ($all_images as $key => $attachment_id) {
            $attach = Attachment::find($attachment_id);

            // проверка на соответствие имени стандартам #68165 
            // https://b24.ac-step.com/workgroups/group/86/tasks/task/view/68165/
            
            // (берется слаг товара и используется в качестве имени)
            if(!Str::contains($attach->name, $this->model->slug)){
                
                $current_path = $attach->physicalPath();
                do {
                    $name = $this->model->slug . '-' . random_int(0, 100);
                    $find = Attachment::where('name' , $name)->first();
                } while ($find);
                $attach->fill(['name' => $name, 'original_name' => $name])->save();
                
                // на боевом можно использовать вариацию с move, а не copy,
                // но сейчас нужен copy, т.к. при посеве изображений иногда изображения дублируются 
                // Storage::disk('public')->move($current_path, $attach->physicalPath());
                if(!Storage::disk('public')->exists($attach->physicalPath()))
                    Storage::disk('public')->copy($current_path, $attach->physicalPath());
                
            }

            ProductsImage::updateOrCreate([
                'course_id' => $this->model->id,
                'attachment_id' => $attachment_id,
            ], [
                'sort' => $key,
                'type_image' => $attach->mime
            ]);
        }
    }

    public function saveVariantsImages(array $images)
    {
        foreach ($images as $variantId => $attachment_ids) {
            $images_to_delete = ProductsVariantsImage::where('variant_id', $variantId)->whereNotIn('attachment_id', $attachment_ids)->get();
            $images_to_delete->each->delete();
        }
        
        foreach ($images as $variantId => $attachment_ids) {
            foreach ($attachment_ids as $key=>$attachment_id) {
                $attach = Attachment::find(IntVal($attachment_id));

                // (берется слаг товара и используется в качестве имени)
                if (! Str::contains($attach->name, $this->model->slug .'-'. $variantId)) {
                    $current_path = $attach->physicalPath();
                    do {
                        $name = $this->model->slug . '-'. $variantId . '-' . random_int(0, 100);
                        $find = Attachment::where('name', $name)->first();
                    } while ($find);
                    $attach->fill(['name' => $name, 'original_name' => $name])->save();
                    
                    // на боевом можно использовать вариацию с move, а не copy,
                    // но сейчас нужен copy, т.к. при посеве изображений иногда изображения дублируются
                    // Storage::disk('public')->move($current_path, $attach->physicalPath());
                    if (! Storage::disk('public')->exists($attach->physicalPath())) {
                        Storage::disk('public')->copy($current_path, $attach->physicalPath());
                    }
                }

                ProductsVariantsImage::updateOrCreate([
                    'variant_id' => $variantId,
                    'attachment_id' => IntVal($attachment_id),
                ], [
                    'sort' => $key,
                    'type_image' => $attach->mime,
                ]);
            }
        }
    }

    public function saveMarkers(array $markers)
    {
        $this->model->active = isset($markers['active']);
        $this->model->marker_new = isset($markers['marker_new']);
        $this->model->marker_top = isset($markers['marker_top']);
        $this->model->marker_sale = isset($markers['marker_sale']);
        $this->model->marker_popular = isset($markers['marker_popular']);
        $this->model->marker_archive = isset($markers['marker_archive']);

        $this->model->save();
    }

    public function saveVariants(array $variants)
    {
        foreach($variants['variant'] as $variant){
           $productsVariant = ProductsVariant::where('course_id', $this->model->id)->where('external_id', $variant['external_id'])->first();
           $productsVariant->update(
               [
                    // 'price' => $variant['price'], 
                    'price_sale' => $variant['price_sale'], 
                    'master' => $variant['master'], 
                    // 'quantity' => $variant['quantity']
                ]
            );
        }
    }
}
