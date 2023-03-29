<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return 
        [
            'id' => $this->id,
            'ordered_at' => $this->created_at,
            'status' => $this->status,
            'is_insured' => $this->is_insured,
            'clientAddress_id' => $this->clientAddress_id,
            'status' => $this->status,
            'prescription' => $this->images
        ];
    }
}
