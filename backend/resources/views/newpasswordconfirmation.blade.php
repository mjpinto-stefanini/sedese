@component('mail::message')
# Sucesso
A sua senha foi alterada com sucesso. Por favor, faça login com a sua nova senha.

<a href="{{ config('app.client_url') }}">Login</a>

Obrigado,<br>
{{ config('app.name') }}
@endcomponent

