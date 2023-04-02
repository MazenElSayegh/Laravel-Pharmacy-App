<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'area'=>new AreaResource($this->area),
            'street_name'=> $this->street_name,
            'build_no' => $this->build_no,
            'floor_no' => $this->floor_no,
            'flat_no' => $this->flat_no,
            'is_main' => $this->is_main==1 ? 'YES' :'NO',

        ];
    }
}
