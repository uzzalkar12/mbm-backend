<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductRequisitionItemDetail extends Model
{
    use HasFactory;

    protected $fillable = ['product_requisition_id', 'product_id', 'product_stock_id',  'supplier_id', 'accept_quantity', 'total_amount'];

    public function productRequisition() : BelongsTo
    {
        return $this->belongsTo(ProductRequisition::class);
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productStock() : BelongsTo
    {
        return $this->belongsTo(ProductStock::class);
    }

    public function supplier() : BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
