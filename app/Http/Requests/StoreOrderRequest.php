<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class StoreOrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            'status' => 'nullable|in:pending,processing,shipped,delivered,cancelled,returned,refunded,completed',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
