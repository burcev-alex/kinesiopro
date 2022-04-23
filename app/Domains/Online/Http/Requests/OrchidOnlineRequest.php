<?php
namespace App\Domains\Online\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrchidOnlineRequest extends FormRequest
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
     * Get the validation rules that apsaveComponentsply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'online.slug' => 'required|max:255',
            'online.title' => 'required|max:255',
            'online.type' => 'required',
            'online.active' => '',
            'online.sort' => 'required|integer',
            'online.attachment_id' => 'required',
            'online.*' => '',
            'components.*' => '',
        ];
    }
}
