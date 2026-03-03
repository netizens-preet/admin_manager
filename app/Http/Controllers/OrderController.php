<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCancellationRequest;
use App\Http\Requests\OrderRequest;
use App\Mail\OrderCancelledByAdminMail;
use App\Mail\OrderCancelledByCustomerMail;
use App\Mail\OrderUpdateMail;
use App\Mail\OrderPlacedMail;
use App\Models\Order;
use App\Models\User;
use App\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = auth()->user();

        $query = Order::with('user')
            ->where('status', '!=', 'pending')
            ->latest();

        // If not admin, only show own orders
        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        $orders = $query->paginate(10);

        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // if (auth()->user()->isAdmin()) {
        //     abort(403, 'Administrators cannot create orders.');
        // }
        return view('order.create');
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        abort(403, 'Administrators cannot edit orders directly.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, Order $order)
    {
        // if (!auth()->user()->isAdmin()) {
        //     abort(403, 'Unauthorized.');
        // }
        $newStatus = $request->status;
        $newStatusEnum = OrderStatus::from($newStatus);

        if (!$order->status->canTransitionTo($newStatusEnum)) {
            return back()->with('error', 'Invalid status transition.');
        }

        $order->update($request->validated());

        if ($newStatusEnum !== $order->status) {
            Mail::to($order->user)->queue(new OrderUpdateMail($order));
        }
        return redirect()->route('order.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        abort(403, 'Orders cannot be deleted.');
    }

    /**
     * Show the billing page for a pending order.
     */
    public function billing(Order $order)
    {
        // if (auth()->user()->isAdmin()) {
        //     abort(403, 'Administrators do not have a billing page.');
        // }

        // if ($order->user_id !== auth()->id()) {
        //     abort(403, 'Unauthorized.');
        // }

        if ($order->status->value !== 'pending') {
            return redirect()->route('order.show', $order)
                ->with('error', 'This order is no longer editable.');
        }

        if ($order->items()->count() === 0) {
            return redirect()->route('order.show', $order)
                ->with('error', 'Add at least one item before proceeding to billing.');
        }

        $order->load(['user', 'items.product']);
        return view('order.billing', compact('order'));
    }

    /**
     * Finalize the order and move it to processing.
     */
    public function placeOrder(Request $request, Order $order)
    {
        // dd($order->toArray());
        // if (auth()->user()->isAdmin()) {
        //     abort(403);
        // }

        // if ($order->user_id !== auth()->id()) {
        //     abort(403, 'Unauthorized.');
        // }

        if ($order->status->value !== 'pending') {
            return back()->with('error', 'Only pending orders can be placed.');
        }

        if ($order->items()->count() === 0) {
            return back()->with('error', 'Cannot place an empty order. Please add at least one item.');
        }

        $request->validate([
            'shipping_address' => 'required|string|min:5',
            'note' => 'nullable|string|max:500',
        ]);

        $order->update([
            'status' => 'processing',
            'shipping_address' => $request->shipping_address,
            'note' => $request->note,
        ]);

        // Send confirmation mail to customer
        Mail::to($order->user)->queue(new OrderPlacedMail($order));

        return redirect()->route('order.index')->with('success', 'Order #' . $order->id . ' has been placed successfully and is now processing.');
    }

    /**
     * Cancel the order (Customer or Admin).
     */
    public function cancel(Order $order)
    {
        $user = auth()->user();

        //This is for customer only
        // if (!$user->isAdmin() && $order->user_id !== $user->id) {
        //     dd("not admin");
        //     abort(403, 'Unauthorized.');
        // }

        if (in_array($order->status->value, ['delivered', 'cancelled'])) {
            return back()->with('error', 'This order cannot be cancelled.');
        }

        $order->update(['status' => 'cancelled']);

        if (!$user->isAdmin()) {
            // Notify customer that they cancelled
            Mail::to($order->user)->queue(new OrderCancelledByCustomerMail($order));
        }

        return back()->with('success', 'Order #' . $order->id . ' has been cancelled.');
    }
}
