<?php

namespace App\Http\Requests\Admin\CourseCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cc_name'=> 'required|string|max:255',
            'icon_path'=>'nullable|file|image|mimes:jpeg,png,gif|max:2048', 
            'parent_id'=>'nullable|integer|exists:course_categories,cc_id',
            'status' => 'nullable|boolean',
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
