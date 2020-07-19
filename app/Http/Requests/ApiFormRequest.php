<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class ApiFormRequest extends FormRequest
{

    protected function failedValidation(Validator $validator): void
    {
        $response = [
            'success' => false,
            'message' => 'Validation Error',
            'errors' => $validator->errors()->all()
        ];
        $jsonResponse = response()->json($response, 400);

        throw new HttpResponseException($jsonResponse);
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
