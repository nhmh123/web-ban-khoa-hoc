<?php

namespace App\Http\Requests\Admin\CourseCategory;

use Illuminate\Foundation\Http\FormRequest;

class CreateCCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cc_name'=> 'sometimes|required|string|max:255',
            'icon_path'=>'sometimes|nullable|file|image|mimes:jpeg,png,gif|max:2048', 
            'parent_id'=>'nullable|integer|exists:course_categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'cc_name.required' => 'Tên danh mục không được bỏ trống.',
            'cc_name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
        ];
    }
}
