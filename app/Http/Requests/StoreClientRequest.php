<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email'=>['required','unique:users,email,'.$this->user],
            'national_id'=>['required','unique:clients,national_id,'.$this->client],
            'password' => ['required','min:6'],
            'avatar' => ['mimes:jpeg,png,jpg'],
        ];
    }
}
