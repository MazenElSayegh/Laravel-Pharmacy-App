<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'client_name'=>['required'],
            'pharmacy_name'=>['required'],
            'doctor_name'=>['required'],
            // 'medicine_name[]'=>['required'],
            'medicine_qty[]'=>['required|integer|min:0'],
            // 'medicine_price[]'=>['required'],
            'is_insured'=>['required'],
            'delivering_address'=>['required'],
        ];
    }
}
