<x-mail::message>
    # Order Status Updated
    Hello {{ $order->user->name }},
    Your order **#{{ $order->id }}** has been updated to: **{{ ucfirst($order->status) }}**.
    <x-mail::button :url="route('order.show', $order)">
        View Order Details
    </x-mail::button>
    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>