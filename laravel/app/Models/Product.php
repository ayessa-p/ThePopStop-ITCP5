<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'series',
        'brand',
        'price',
        'cost_price',
        'sku',
        'description',
        'character',
        'stock_quantity',
        'category',
        'type',
        'image_url',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'stock_quantity' => 'integer',
    ];

    public function productPhotos(): HasMany
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(Cart::class, 'product_id');
    }

    public function purchaseOrderItems(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class, 'product_id');
    }

    /**
     * Update product status based on stock_quantity.
     */
    public function updateStatus(): void
    {
        if ($this->stock_quantity > 10) {
            $this->update(['status' => 'In Stock']);
        } elseif ($this->stock_quantity > 0) {
            $this->update(['status' => 'Low Stock']);
        } else {
            $this->update(['status' => 'Out of Stock']);
        }
    }
}
