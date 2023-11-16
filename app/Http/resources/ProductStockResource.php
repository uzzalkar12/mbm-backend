<?php

namespace App\Http\resources;

use App\Models\ProductRequisitionItemDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductStockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $item_detail = ProductRequisitionItemDetail::query()
            ->where('product_id', $this->product_id)
            ->where('product_stock_id', $this->id)
            ->first();

        $accept_quantity = $total_amount = 0;
        $supplier_id = null;
        if ($item_detail){
            $accept_quantity = $item_detail->accept_quantity;
            $total_amount = $item_detail->total_amount;
            $supplier_id = $item_detail->supplier_id;
        }

        return [
            'id'              => $this->id,
            'product_id'      => $this->product_id,
            'quantity'        => $this->quantity,
            'unit_price'      => $this->unit_price,
            'created_at'      => $this->created_at,
            'accept_quantity' => $accept_quantity,
            'total_amount'    => $total_amount,
            'supplier_id'     => $supplier_id,
        ];
    }
}
