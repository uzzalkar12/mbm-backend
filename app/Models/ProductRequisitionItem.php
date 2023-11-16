<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ProductRequisitionItem extends Model
{
    use HasFactory;

    protected $fillable = ['product_requisition_id', 'product_id', 'requested_quantity', 'requested_amount', 'requested_comment'];

    public function productRequisition() : BelongsTo
    {
        return $this->belongsTo(ProductRequisition::class);
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productStocks() : HasManyThrough
    {
        return $this->hasManyThrough(ProductStock::class, Product::class, 'id', 'product_id','product_id', 'id')
            ->where('quantity', '>',  0);
    }

//    public function productStocks() : HasMany
//    {
//        return $this->hasMany(ProductStock::class)->where('quantity', '>',  0);
//    }
}
