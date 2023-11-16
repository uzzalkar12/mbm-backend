<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'unit'];

    public function productStocks() : HasMany
    {
        return $this->hasMany(ProductStock::class)->where('quantity', '>',  0);
    }
}
