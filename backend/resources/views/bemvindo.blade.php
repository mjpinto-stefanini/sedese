{{-- Blade seja bem vindo --}}
@component('mail::message')

# Seja bem-vindo ao SISCAP do SEDESE

<p>Olá {{$name}}, clique no link abaixo para concluir seu cadastro.</p>

<a href="{{ config('app.asset_url') }}" class="btn btn-primary">Cadastro</a>

<p>Obrigado,<br>
{{ config('app.name') }}</p>

@endcomponent

