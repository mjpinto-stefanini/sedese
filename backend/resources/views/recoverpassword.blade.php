@component('mail::message')
# Recuperação de email

Olá você está recebendo este email pois escolheu recuperar sua senha no sistema SISCAP SEDESE. Caso não tenha feita
esta solicitação, por favor ignore este email.

<a href="{{ config('app.client_url') }}/recoverpassword/{{$token}}">Recuperar Senha</a>

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
