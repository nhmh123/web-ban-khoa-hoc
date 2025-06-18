<?php

namespace App\Http\Requests\Lecture;

use App\Enums\LectureEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLectureRequest extends FormRequest
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
        $rule = [
            'title' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|in:video,article',
        ];

        switch ($this->type) {
            case LectureEnum::ARTICLE->value:
                $rule = array_merge($rule, [
                    'article_content' => 'required|string',
                ]);
                break;
            default:
                break;
        }

        return $rule;
    }

    public function messages()
    {
        return [
            'article_content.required' => 'Nội dung bài giảng không được bỏ trống!'
        ];
    }
}
