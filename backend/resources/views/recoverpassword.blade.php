@component('mail::message')
# Recuperação de email

Olá você está recebendo este email pois escolheu recuperar sua senha no sistema SISCAP SEDESE. Caso não tenha feita
esta solicitação, por favor ignore este email.

<a href="http://200.198.62.82/recoverpassword/{{$token}}">Recuperar Senha</a>

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
