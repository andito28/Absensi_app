<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends FormRequest
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
            'nama' => 'required',
            'posisi' => 'required',
            'hp' => 'required|numeric|unique:users,hp',
            'password' => 'required',
            'jenis_kelamin' => 'required'
        ];
    }

    public function failedValidation(Validator $validator)
    {
    throw new HttpResponseException(response()->json([
        'message'   => 'Validation errors',
        'data'      => $validator->errors()
    ],500));
    }

}
