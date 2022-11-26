<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTaskRequest extends FormRequest
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
            'name' => 'bail|required|max:20',
            'starts_at' => 'bail|required|after:now',
            'description' => 'bail|required|min:10'
        ];
    }

    public function messages()
    {
        return [
            'name' => [
                'required' => 'O campo nome não pode estar vazio',
                'max' => 'O nome não pode ter mais de 20 caracteres'
            ],
            'starts_at' => [
                'required' => 'O campo data não pode estar vazio',
                'after' => 'A data deve ser posterior a data atual'
            ],
            'description' => [
                'required' => 'O campo descrição não pode estar vazio',
                'min' => 'A descrição deve ter no mínimo 10 caracteres'
            ]
        ];
    }

    public function failedValidation(Validator $validator)
    {
        //write your bussiness logic here otherwise it will give same old JSON response
        throw new HttpResponseException(response()->json($validator->errors(), 404));
    }
}
