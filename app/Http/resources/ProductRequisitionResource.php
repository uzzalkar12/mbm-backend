<?php

namespace App\Http\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductRequisitionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $productRequisitionItems = $this->whenLoaded('productRequisitionItems');
        $product = $this->whenLoaded('product');
        return [
            'id'                         => $this->id,
            'product_requisition_number' => $this->product_requisition_number,
            'user_id'                    => $this->user_id,
            'created_at'                 => $this->created_at,
            'product'                    => new ProductResource($product),
            'product_requisition_items'  => ProductRequisitionItemResource::collection($productRequisitionItems),
        ];
    }
}
