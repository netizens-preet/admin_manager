<?php

namespace App\Models;
use App\OrderStatus;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'subtotal', 'total', 'status', 'shipping_address', 'note'];

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function syncTotals(): void
    {
        $newTotal = $this->items()->sum('total_price');
        $this->update([
            'subtotal' => $newTotal,
            'total' => $newTotal,
        ]);
    }
}
