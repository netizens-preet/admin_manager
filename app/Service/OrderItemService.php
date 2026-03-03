<?php

namespace App\Services;

use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderItemService
{
    /**
     * Handle creating an order item and updating the parent order.
     */
    public function createItem(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Calculate total price if not provided
            if (!isset($data['total_price'])) {
                $data['total_price'] = $data['unit_price'] * $data['quantity'];
            }

            $item = OrderItem::create($data);
            
            // Sync parent order totals
            $item->order->syncTotals();

            return $item;
        });
    }

    /**
     * Handle updating an order item and re-syncing totals.
     */
    public function updateItem(OrderItem $item, array $data)
    {
        return DB::transaction(function () use ($item, $data) {
            if (!isset($data['total_price'])) {
                $data['total_price'] = $data['unit_price'] * $data['quantity'];
            }

            $item->update($data);
            $item->order?->syncTotals();

            return $item;
        });
    }

    /**
     * Handle deleting an item and re-syncing totals.
     */
    public function deleteItem(OrderItem $item)
    {
        return DB::transaction(function () use ($item) {
            $order = $item->order;
            $item->delete();
            $order?->syncTotals();
            
            return true;
        });
    }
}