<x-mail::message>
    # Order #{{ $order->id }} Cancelled

    Hello {{ $order->user->name }},

    Your order **#{{ $order->id }}** has been cancelled by an administrator.

    @if($reason)
        **Reason:** {{ $reason }}
    @endif

    We apologize for any inconvenience.

    <x-mail::button :url="route('order.show', $order)">
        View Order Details
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}