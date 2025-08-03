<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class CreateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|file|image|mimes:jpeg,png,gif|max:4096',
            'original_price' => 'required|numeric|min:0|max:9999999',
            'short_description' => 'nullable|string',
            'enroll_requirements' => 'nullable|string',
            'audience' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'cat_id' => 'required|integer|exists:course_categories,cc_id',
            'language_id' => 'required|integer|exists:languages,lang_id',
            'level_id' => 'required|integer|exists:difficulty_levels,level_id',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên khóa học là bắt buộc.',
            'name.max' => 'Tên khóa học không được vượt quá 255 ký tự.',
            'original_price.required' => 'Giá gốc là bắt buộc.',
            'original_price.numeric' => 'Giá gốc phải là số.',
            'original_price.min' => 'Giá gốc tối thiểu là 0đ.',
            'original_price.max' => 'Giá gốc tối đa là 9,999,999đ.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'cat_id.required' => 'Danh mục là bắt buộc.',
            'cat_id.exists' => 'Danh mục không tồn tại.',
            'language_id.required' => 'Ngôn ngữ là bắt buộc.',
            'language_id.exists' => 'Ngôn ngữ không tồn tại.',
            'level_id.required' => 'Trình độ là bắt buộc.',
            'level_id.exists' => 'Trình độ không tồn tại.',
        ];
    }
}
