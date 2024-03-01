<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class UpdateProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['string', 'sometimes', 'max:255'],
            'description' => ['string', 'sometimes'],
            'price' => ['numeric', 'sometimes'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
