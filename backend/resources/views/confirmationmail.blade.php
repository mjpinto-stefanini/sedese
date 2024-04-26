@component('mail::message')
# Confirmação de email

Olá {{$name}}, clique no link abaixo para confirmar seu email.

<a href="{{ config('app.client_url') }}/confirmar-email/{{$token}}">{{ config('app.client_url') }}/users/confirm-email/{{$token}}</a>

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
