<?php

namespace App\Services;

use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class OrderItemService
{
    /**
     * Handle creating an order item and updating the parent order.
     */
    public function createItem(array $data)
    {
        DB::beginTransaction();
        try {
            // Calculate total price 
            if (!isset($data['total_price'])) {
                $data['total_price'] = $data['unit_price'] * $data['quantity'];
            }

            $item = OrderItem::create($data);
            
            // Sync parent 
            $item->order->syncTotals();

            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Order Item Creation Failed', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            throw $e;
        }
    }

    /**
     * Handle updating an order item and re-syncing totals.
     */
    public function updateItem(OrderItem $item, array $data)
    {
        DB::beginTransaction();
        try {
            if (!isset($data['total_price'])) {
                $data['total_price'] = $data['unit_price'] * $data['quantity'];
            }

            $item->update($data);
            $item->order?->syncTotals();

            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Order Item Update Failed', [
                'error' => $e->getMessage(),
                'item_id' => $item->id
            ]);
            throw $e;
        }
    }

    /**
     * Handle deleting an item and re-syncing totals.
     */
    public function deleteItem(OrderItem $item)
    {
        DB::beginTransaction();
        try {
            $order = $item->order;
            
            $item->delete();
            
            if ($order) {
                $order->syncTotals();
            }
            
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Order Item Deletion Failed', [
                'error' => $e->getMessage(),
                'item_id' => $item->id
            ]);
            throw $e;
        }
    }
}