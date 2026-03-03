<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderItemRequest;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\OrderItemService;
use Illuminate\Http\Request;

class OrderItemsController extends Controller
{
    public function __construct(
        protected OrderItemService $itemService
    ) {
    }
    public function index()
    {
        $query = OrderItem::with(['order', 'product'])->get();
        return view('order-item.index', compact('query'));
    }

    public function create(Request $request)
    {
        $orderId = $request->query('order_id');
        $products = Product::where('is_active', true)->get();
        return view('order-item.create', compact('orderId', 'products'));
    }

    public function store(OrderItemRequest $request)
    {
        try {
            $item = $this->itemService->createItem($request->validated());
            return redirect()->route('order.show', $item->order_id)
                ->with('success', 'Item added to order.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add item: ' . $e->getMessage());
        }
    }

    public function update(OrderItemRequest $request, OrderItem $orderItem)
    {
        try {
            // Logic: Block modification if the order is already processed/shipped
            if (in_array($orderItem->order->status->value, ['shipped', 'delivered', 'cancelled'])) {
                throw new \Exception('This order is locked and items cannot be modified.');
            }

            $this->itemService->updateItem($orderItem, $request->validated());

            return redirect()->route('order.show', $orderItem->order_id)
                ->with('success', 'Item updated.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(OrderItem $orderItem)
    {
        try {
            // Logic check in controller
            if ($orderItem->order->status->value !== 'pending') {
                throw new \Exception('Items can only be removed from pending orders.');
            }

            $orderId = $orderItem->order_id;
            $this->itemService->deleteItem($orderItem);

            return redirect()->route('order.show', $orderId)
                ->with('success', 'Item removed and totals updated.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}