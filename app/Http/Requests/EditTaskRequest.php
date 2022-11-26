<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EditTaskRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'max:20',
            'starts_at' => 'after:now',
            'description' => 'min:10'
        ];
    }

    public function messages()
    {
        return [
            'name' => [
                'max' => 'O nome não pode ter mais de 20 caracteres'
            ],
            'starts_at' => [
                'after' => 'A data deve ser posterior a data atual'
            ],
            'description' => [
                'min' => 'A descrição deve ter no mínimo 10 caracteres'
            ]
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 404));
    }
}
