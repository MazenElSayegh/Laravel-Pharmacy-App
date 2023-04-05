<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

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
        $user = DB::table("users")->where("typeable_id", $this->client)->where("typeable_type","App\Models\Client")->first();
        return [
            'email'=>['required','unique:users,email,'.$user->id],
            'national_id'=>['required','unique:clients,national_id,'.$this->client],
            'password' => ['required','min:6'],
            'avatar' => ['mimes:jpeg,png,jpg'],
        ];
    }
}
