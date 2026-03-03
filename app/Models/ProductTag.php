<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductTag extends Pivot
{
    public $table = 'product_tags';
    protected $fillable = [
        'product_id',
        'tag_id',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
        ];
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
