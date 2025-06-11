<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255',
            'thumbnail' => 'sometimes|nullable|file|image|mimes:jpeg,png,gif|max:2048',
            'original_price' => 'sometimes|nullable|required|numeric|min:0',
            'short_description' => 'sometimes|nullable|string',
            'enroll_requirements' => 'sometimes|nullable|string',
            'audience' => 'sometimes|nullable|string',
            'status' => 'sometimes|required|in:draft,published',
            'cat_id' => 'sometimes|required|integer|exists:course_categories,cc_id',
            'language_id' => 'sometimes|required|integer|exists:languages,lang_id',
            'level_id' => 'sometimes|required|integer|exists:difficulty_levels,level_id',
            'description' => 'sometimes|nullable|string',
            'content' => 'sometimes|nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên khóa học là bắt buộc.',
            'name.max' => 'Tên khóa học không được vượt quá 255 ký tự.',
            'original_price.required' => 'Giá gốc là bắt buộc.',
            'original_price.numeric' => 'Giá gốc phải là số.',
            'original_price.min' => 'Giá gốc phải lớn hơn hoặc bằng 0.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'cat_id.required' => 'Danh mục là bắt buộc.',
            'cat_id.exists' => 'Danh mục không tồn tại.',
            'language_id.required' => 'Ngôn ngữ là bắt buộc.',
            'language_id.exists' => 'Ngôn ngữ không tồn tại.',
            'level_id.required' => 'Trình độ là bắt buộc.',
            'level_id.exists' => 'Trình độ không tồn tại.'
        ];
    }
}
