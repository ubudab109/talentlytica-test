<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateParticipantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'fullname' => 'required',
            'email'    => ['required', 'email', Rule::unique('participants')->ignore($this->participant)],
            'x'        => 'required|integer|between:1,33',
            'y'        => 'required|integer|between:1,23',
            'z'        => 'required|integer|between:1,18',
            'w'        => 'required|integer|between:1,13',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'status' => 'failed',
            'error'  => $validator->errors()
        ], 422));
    }

    /**
     * Messages error for each validation
     * 
     * @return array
     */
    public function messages(): array
    {
        return [
            'fullname.required' => 'Fullname required',
            'email.required'    => 'Email Required',
            'email.unique'      => 'Email already take',
            'email.email'       => 'Email is invalid',
            'x.required'        => 'X Value is required',
            'x.between'         => 'X Value should be between 1-33',
            'y.required'        => 'Y Value is required',
            'y.between'         => 'Y Value should be between 1-23',
            'z.required'        => 'X Value is required',
            'z.between'         => 'X Value should be between 1-18',
            'w.required'        => 'W Value is required',
            'w.between'         => 'W Value should be between 1-13',
        ];
    }
}
