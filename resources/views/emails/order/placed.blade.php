# Order Confirmation

Hello {{ $order->user->name }},

Your order **#{{ $order->id }}** has been successfully placed and is now being processed.

**Order Summary:**
- Total Amount: ${{ number_format($order->total, 2) }}
- Status: {{ ucfirst($order->status) }}

<x-mail::button :url="route('order.show', $order)">
    View Order Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}