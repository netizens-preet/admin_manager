# Order #{{ $order->id }} Cancelled

Hello Admin,

Customer **{{ $order->user->name }}** has cancelled their order **#{{ $order->id }}**.

<x-mail::button :url="route('order.show', $order)">
    View Order Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}