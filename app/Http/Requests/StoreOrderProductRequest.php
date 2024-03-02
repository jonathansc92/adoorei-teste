<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class StoreOrderProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'product_id' => 'integer|required|exists:orders,id',
            'order_id' => 'integer|required|exists:orders,id',
            'amount' => 'numeric|required',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
