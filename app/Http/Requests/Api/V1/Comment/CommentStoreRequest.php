<?php

namespace App\Http\Requests\Api\V1\Comment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommentStoreRequest extends FormRequest
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
            'text' => ['required', 'string', 'max:500'],
            'article_id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'article_id.required'      => 'Поле article_id является обязатьным', 
            'text.required'            => 'Поле text является обязатьным',
            'text.max'                 => 'Максимальная длина комментария должна составлять 500 символов '
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json([
            'message' => $validator->errors(),
        ], 400));
    }

}
