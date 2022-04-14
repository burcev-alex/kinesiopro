<?php
namespace App\Domains\Course\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrchidCourseRequest extends FormRequest
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
            'course.slug' => 'required|max:255',
            'course.name' => 'required|max:255',
            'course.active' => '',
            'course.sort' => 'required|integer',
            'course.category_id' => 'required',
            'course.*' => '',
            'property_values.*' => '',
            'blocks.*' => '',
            'components.*' => '',
            'markers.*' => '',
            'teachers.*' => '',
        ];
    }
}
