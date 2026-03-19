<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, SoftDeletes, Searchable;

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

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'series' => $this->series,
            'brand' => $this->brand,
            'description' => $this->description,
            'sku' => $this->sku,
            'character' => $this->character,
            'category' => $this->category,
            'type' => $this->type,
        ];
    }

    /**
     * Get the correct URL for the product image (thumbnail).
     * Prioritizes the primary photo from the gallery, then the main image_url.
     */
    public function getPhotoUrlAttribute(): string
    {
        // 1. Check for a primary photo in the gallery
        $primaryPhoto = $this->productPhotos()->where('is_primary', true)->first();
        if ($primaryPhoto) {
            return $primaryPhoto->url;
        }

        // 2. Fallback to the main image_url (Excel)
        if ($this->image_url) {
            if (preg_match('/^https?:\/\//i', $this->image_url)) {
                return $this->image_url;
            }
            return route('image.serve', ['path' => ltrim($this->image_url, '/')]);
        }

        // 3. Ultimate fallback
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random&color=fff&size=128';
    }

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
