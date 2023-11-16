<?php

namespace App\Http\resources;

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
        $productStocks = $this->whenLoaded('productStocks');
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'unit'           => $this->unit,
            'created_at'     => $this->created_at,
            'product_stocks' => ProductStockResource::collection($productStocks)
        ];
    }
}
