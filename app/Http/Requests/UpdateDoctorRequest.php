<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateDoctorRequest extends FormRequest
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
        $user = DB::table("users")->where("typeable_id", $this->doctor)->where("typeable_type","App\Models\Doctor")->first();
        return [
            'email'=>['required','unique:users,email,'.$user->id],
            'national_id'=>['required','unique:doctors,national_id,'.$this->doctor],
            'password' => ['required','min:6'],
            'avatar_image' => ['mimes:jpeg,png,jpg'],
        ];
    }
}
