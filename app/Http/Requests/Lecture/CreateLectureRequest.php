<?php

namespace App\Http\Requests\Lecture;

use App\Enums\LectureEnum;
use Illuminate\Foundation\Http\FormRequest;

class CreateLectureRequest extends FormRequest
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
        // dd($this->type);
        $rule = [
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,article',
            'sec_id' => 'required|exists:sections,sec_id',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120',
        ];

        switch ($this->type) {
            case LectureEnum::ARTICLE->value:
                $rule = array_merge($rule, [
                    'article_content' => 'required|string',
                ]);
                break;
            case LectureEnum::VIDEO->value:
                $rule = array_merge($rule, [
                    'course_video' => 'required|file|mimes:mp4,mov,avi,wmv,mkv,flv|max:512000',
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
            'article_content.required' => 'Nội dung bài giảng không được bỏ trống!',
            'course_video.required' => 'Video vài giảng không được để trống',
            'course_video.mimes' => 'Sai định dạng video',
            'course_video.max' => 'Kích thước video quá lớn'
        ];
    }
}
