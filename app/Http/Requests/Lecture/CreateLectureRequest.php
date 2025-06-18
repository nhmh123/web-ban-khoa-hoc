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
}
