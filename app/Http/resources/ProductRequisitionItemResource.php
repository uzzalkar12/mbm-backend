<?php

namespace App\Http\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductRequisitionItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = $this->whenLoaded('product');
        $productRequisition = $this->whenLoaded('productRequisition');
        $productStocks = $this->whenLoaded('productStocks');

        return [
            'id'                     => $this->id,
            'product_requisition_id' => $this->product_requisition_id,
            'product_id'             => $this->product_id,
            'requested_quantity'     => $this->requested_quantity,
            'requested_amount'       => $this->requested_amount,
            'requested_comment'      => $this->requested_comment,
            'created_at'             => $this->created_at,
            'product'                => new ProductResource($product),
            'product_requisition'    => new ProductRequisitionResource($productRequisition),
            'product_stocks'         => ProductStockResource::collection($productStocks),
        ];


    }
}
