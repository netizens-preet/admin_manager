<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderItemRequest;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = OrderItem::with(['order', 'product'])->get();
        return view('order-item.index', compact('query'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $orderId = $request->query('order_id');
        $products = Product::where('is_active', true)->get();

        return view('order-item.create', compact('orderId', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderItemRequest $request)
    {
        // if (auth()->user()->isAdmin()) {
        //     abort(403, 'Admins cannot modify order items.');
        // }
        $validated = $request->validated();
        if (!isset($validated['total_price'])) {
            $validated['total_price'] = $validated['unit_price'] * $validated['quantity'];
        }
        $item = OrderItem::create($validated);
        $item->order->syncTotals();

        return redirect()->route('order.show', $item->order_id)->with('success', 'Item added to order.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderItem $orderItem)
    {
        $orderItem->load(['order', 'product']);
        return view('order-item.show', compact('orderItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderItem $orderItem)
    {
        $orderItem->load(['order', 'product']);
        $products = Product::where('is_active', true)->get();
        return view('order-item.edit', compact('orderItem', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderItemRequest $request, OrderItem $orderItem)
    {
        // if (auth()->user()->isAdmin()) {
        //     abort(403, 'Admins cannot modify order items.');
        // }
        $validated = $request->validated();
        if (!isset($validated['total_price'])) {
            $validated['total_price'] = $validated['unit_price'] * $validated['quantity'];
        }
        $orderItem->update($validated);
        $orderItem->order?->syncTotals();

        return redirect()->route('order.show', $orderItem->order_id)->with('success', 'Item updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderItem $orderItem)
    {
        // if (auth()->user()->isAdmin()) {
        //     abort(403, 'Admins cannot modify order items.');
        // }
        $order = $orderItem->order;
        $orderItem->delete();
        $order?->syncTotals();

        return redirect()->back()->with('success', 'Item removed and order totals synchronized.');
    }
}
