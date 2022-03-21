<?php


namespace App\Domains\Product\Http\Controllers\Api;

use App\Domains\Product\Models\RefChar;
use App\Domains\Product\Models\RefCharsTranslation;
use App\Domains\Product\Models\RefCharsValue;
use App\Domains\Applicability\Models\Applicability;
use App\Domains\Applicability\Models\ApplicabilityTranslation;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use function Symfony\Component\String\b;

class CharControllers extends BaseController
{
    private $langs = [];

    public function import(Request $request){
        $data = json_decode($request->getContent(), true);
        
        if (! empty($data)) {
            $sourceFileName = 'chars.json';
            $fileFullPath = 'app/tmp'; // Соответствует storage/app/public/

            Storage::disk('local')->makeDirectory('tmp');

            $file = storage_path($fileFullPath.'/'.$sourceFileName);

            if (file_exists($file)) {
                unlink($file);
            }

            file_put_contents($file, $request->getContent());
        }

        $rules = [
            'chars' => 'required|array|min:1',
            'chars.*.type' => 'required|max:255',
            'chars.*.name' => 'required|max:255',
            'chars.*.external_id' => 'required|max:36',
            'chars.*.value' => 'required|array|min:1',
            'chars.*.value.*.external_id' => 'required|max:36',
            'chars.*.value.*.name' => 'required|max:255'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $this->setLangs();

        foreach($data['chars'] as $item){
            $this->updateOrCreateRefChar($item);

        }

        return $this->sendResponse($request->all(), 'Items retrieved successfully.');
    }

    /*
    *
    * Создаем список языков в приватный массив langs
    *
    **/

    private function setLangs(){
        foreach(LaravelLocalization::getSupportedLocales() as $key => $item){
            $this->langs[] = $key;
        }
    }

    /*
    *
    * Создаем или обновляем характеристику
    *
    * @parram array $refChar
    **/

    private function updateOrCreateRefChar($refChar){
        
        //смотрим что это за свойство если "mesto-primeneniya" то обнавляем каталог применимости       
        switch(Str::slug($refChar['name'])){
            case 'mesto-primeneniya':
                $this->updateOrCreateApplication($refChar);
                break;
        }

        //создаем или обновляем название характеристику
        $refchar = RefChar::updateOrCreate([
            'external_id' => $refChar['external_id']
        ],[
            'slug' => Str::slug($refChar['name']),
            'type' => $refChar['type']
        ]);

        foreach($this->langs as $lang){          
            //создаем или обновляем языкавое значение название характеристики 
            switch($lang){
                case 'ru':
                    RefCharsTranslation::updateOrCreate([
                        'char_id' => $refchar->id,
                        'locale' => $lang
                    ],[
                        'name' => $refChar['name']
                    ]);
                    break;
                default:
                    $ref_char_trans = RefCharsTranslation::where('char_id', $refchar->id)->where('locale', $lang)->get();
                    switch($ref_char_trans->count()){
                        case '0':
                            RefCharsTranslation::create([
                                'char_id' => $refchar->id,
                                'local' => $lang,
                                'name' => $refChar['name']
                            ]);
                            break;
                    }
                    break;
            }
            
        }

        $this->updateOrCreateRefCharValue($refChar['value'], $refchar->id);
        return;
    }

    /*
    *
    * Наполнение свойствари характеристик
    *
    * @parram array $refCharValue
    * @parram int $refchar_id
    **/

    private function updateOrCreateRefCharValue($refCharValue, $refchar_id){
        foreach($refCharValue as $value){
            $slug = Str::slug($value['name']);
            
            foreach($this->langs as $lang){
                switch($lang){ 
                    case 'ru': // на русской версии обнавляем или создаем значение характиристикеки
                        RefCharsValue::updateOrCreate([
                            'external_id' => $value['external_id'],
                            'char_id' => $refchar_id,
                            'locale' => $lang
                        ],[
                            'slug' => $slug,
                            'value' => $value['name']
                        ]);
                        break;
                    default:
                        
                        $refCharValueTrans = RefCharsValue::where('external_id', $value['external_id'])
                                                          ->where('char_id', $refchar_id)
                                                          ->where('locale', $lang)
                                                          ->get();

                        switch($refCharValueTrans->count()){
                            case 0: // если $refCharValueTrans->count() получает 0 то мы создаем новое значение характиристикеки
                                RefCharsValue::create([
                                    'external_id' => $value['external_id'],
                                    'char_id' => $refchar_id,
                                    'slug' => $slug,
                                    'locale' => $lang,
                                    'value' => $value['name']
                                ]);
                                break;
                            default: // если $refCharValueTrans->count() получает сколько угодно то мы обновляем столько силмвольное значение свойства характиристикеки
                                $refCharValueTrans->each->update(['slug' => $slug]);
                                break;
                        }
                        break;
                }
            }
        }
        return;
    }


    /*
    *
    * Создаем или обновляем применимость
    *
    * @parram array $applications
    **/

    private function updateOrCreateApplication($applications){
        foreach($applications['value'] as $application){
            $applicability = Applicability::updateOrCreate([
                'slug' => Str::slug($application['name']),
                'external_id' => $application['external_id']
            ],[
                'active' => 1,
                'sort' => 100,
            ]);

            $this->setApplicationTrans($application['name'], $applicability->id);
        }

        return;
    }

    /*
    *
    * Заполняем название данной применимость
    *
    * @parram strong $name
    * @parram int $applicability_id
    **/
    private function setApplicationTrans($name, $applicability_id)
    {
        foreach($this->langs as $lang){
            switch($lang){
                case 'ru':
                    ApplicabilityTranslation::updateOrCreate([
                        'applicability_id' => $applicability_id,
                        'locale' => $lang,
                    ],[
                        'name' => $name
                    ]);
                    break;
                default:
                    $applicabilityTranslation = ApplicabilityTranslation::where('applicability_id', $applicability_id)
                                         ->where('locale', $lang)
                                         ->get();
                    switch($applicabilityTranslation->count()){
                        case '0':
                            ApplicabilityTranslation::create(
                                [
                                    'applicability_id' => $applicability_id,
                                    'locale' => $lang,
                                    'name' => $name,
                                    'description' => $name,
                                ]
                            );
                            break;
                    }
                    break;
            }  
        }
        return;
    }
}