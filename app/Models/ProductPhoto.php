<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'photo_url',
        'is_primary',
        'display_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get the correct URL for the photo.
     */
    public function getUrlAttribute(): string
    {
        if (!$this->photo_url) {
            return asset('images/no-image.png');
        }

        if (preg_match('/^https?:\/\//i', $this->photo_url)) {
            return $this->photo_url;
        }

        // Use the custom img-data route which is more stable on Windows
        return url('/img-data/' . ltrim($this->photo_url, '/'));
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
