<?php
namespace App\Domains\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrchidProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product.slug' => 'required|max:255',
            'product.active' => '',
            'categories' => 'array|min:1',
            'product.article' => '',
            'product.sort' => 'required|integer',
            'product.*' => '', 
            'translations.*.name' => 'required|max:255',
            'translations.*.*' => '',
            'property_values.*' => '', 
            'option_ref_values.*' => '', 
            'images.*' => '', 
            'variants.*' => '', 
            'variants_images.*' => '', 
            // 'ooptions.*' => ''
        ];
    }
}
