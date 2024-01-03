@component('mail::message')
# Confirmação de email

Olá {{$name}}, clique no link abaixo para confirmar seu email.

<a href="http://200.198.62.82:9000/api/v1/users/confirm-email/{{$token}}">https://sedese.social.gov.br/api/v1/users/confirm-email/{{$token}}</a>

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
