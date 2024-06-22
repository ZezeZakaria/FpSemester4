<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = ['product_name', 'description', 'photo', 'stock', 'size', 'status', 'price', 'is_featured', 'cat_id'];

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'cat_id', 'id');
    }

    public function cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function invoiceDetails(): HasMany
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}
