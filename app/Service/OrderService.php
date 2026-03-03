<?php

namespace App\Services;

use App\Models\Order;
use App\OrderStatus;
use App\Mail\OrderUpdateMail;
use App\Mail\OrderPlacedMail;
use App\Mail\OrderCancelledByCustomerMail;
use Illuminate\Support\Facades\Mail;
use Exception;

class OrderService
{
    public function getOrdersForUser($user)
    {
        $query = Order::with('user')->where('status', '!=', 'pending')->latest();
        
        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        return $query->paginate(10);
    }

    public function updateOrderStatus(Order $order, string $newStatus)
    {
        $newStatusEnum = OrderStatus::from($newStatus);

       

        $oldStatus = $order->status;
        $order->update(['status' => $newStatus]);

        if ($newStatusEnum !== $oldStatus) {
            Mail::to($order->user)->queue(new OrderUpdateMail($order));
        }

        return $order;
    }

    public function finalizeOrder(Order $order, array $data)
    {
        

        $order->update([
            'status' => 'processing',
            'shipping_address' => $data['shipping_address'],
            'note' => $data['note'] ?? null,
        ]);

        Mail::to($order->user)->queue(new OrderPlacedMail($order));

        return $order;
    }

    public function cancelOrder(Order $order, $user)
    {
        

        $order->update(['status' => 'cancelled']);

        if (!$user->isAdmin()) {
            Mail::to($order->user)->queue(new OrderCancelledByCustomerMail($order));
        }

        return $order;
    }
}