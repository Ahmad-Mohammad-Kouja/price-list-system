<?php

namespace App\Src\Users\Inventories\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'base_price' => $this->base_price,
            'applicable_price' => $this->when(
                $this->applicable_price !== null,
                $this->applicable_price
            ),
            'description' => $this->when(
                $this->description_id !== null,
                $this->description
            )
        ];
    }
}
