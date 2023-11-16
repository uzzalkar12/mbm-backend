<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductRequisition extends Model
{
    use HasFactory;

    protected $fillable = ['product_requisition_number', 'user_id'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function productRequisitionItems() : HasMany
    {
        return $this->hasMany(ProductRequisitionItem::class);
    }

    public function productRequisitionItemDetails() : HasMany
    {
        return $this->hasMany(ProductRequisitionItemDetail::class);
    }
}
