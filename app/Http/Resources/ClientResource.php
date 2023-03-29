<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'user info' => new UserResource(
            //     $this->type
            // ),
            'id' => $this->id,
            'avatar'=>$this->avatar,
            'national_id'=>$this->national_id,
            'gender'=>$this->gender,
            'birth_day'=> $this->birth_day,
            'mobile'=>$this->mobile,

        ];
    }
}
