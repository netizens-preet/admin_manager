<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = ['category_id', 'name', 'price', 'stock_quantity', 'is_active', 'description'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }
    public function primaryimage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }
    public function orderItems() {
    return $this->hasMany(OrderItem::class);
}
}
