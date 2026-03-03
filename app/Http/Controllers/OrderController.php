<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService) {}

    public function index()
    {
        $orders = $this->orderService->getOrdersForUser(auth()->user());
        return view('order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('order.show', compact('order'));
    }

    public function update(OrderRequest $request, Order $order)
    {
        try {
             if (!$order->status->canTransitionTo($request->status)) {
            throw new \Exception('Invalid status transition.');
        }
            $this->orderService->updateOrderStatus($order, $request->status);
            return redirect()->route('order.show', $order)->with('success', 'Order updated.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function billing(Order $order)
    {
        if ($order->status->value !== 'pending') {
            return redirect()->route('order.show', $order)->with('error', 'Order not editable.');
        }

        $order->load(['user', 'items.product']);
        return view('order.billing', compact('order'));
    }

    public function placeOrder(Request $request, Order $order)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string|min:5',
            'note' => 'nullable|string|max:500',
        ]);

        try {
            if ($order->status->value !== 'pending') {
            throw new \Exception('Only pending orders can be placed.');
        }
        
        if ($order->items()->count() === 0) {
            throw new \Exception('Cannot place an empty order.');
        }
            $this->orderService->finalizeOrder($order, $validated);
            return redirect()->route('order.index')->with('success', 'Order placed successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function cancel(Order $order)
    {
        try {
            if (in_array($order->status->value, ['delivered', 'cancelled'])) {
            throw new \Exception('This order cannot be cancelled.');}
            $this->orderService->cancelOrder($order, auth()->user());
            return back()->with('success', 'Order cancelled.');
        } catch (\Exception $e) {
            
            return back()->with('error', $e->getMessage());
        }
    }
}