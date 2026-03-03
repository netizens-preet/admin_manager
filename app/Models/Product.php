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
        return $this->belongsTo(Category::class)->withDefault([
        'name' => 'Uncategorized',
        'description' => 'This product has no category assigned.'
    ]);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }
    public function primaryimage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags')->withPivot('is_featured');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
