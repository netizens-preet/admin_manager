<x-mail::message>
# Welcome to {{ config('app.name') }}!
Hi {{ $user->name }},
Welcome to {{ config('app.name') }}! We're thrilled to have you on board. If you have any questions or need assistance, feel free to reach out to our support team.
Your account has been succesfully registered and verified at {{ $user->email_verified_at }}
Best regards,
{{ config('app.name') }}
</x-mail::message>
