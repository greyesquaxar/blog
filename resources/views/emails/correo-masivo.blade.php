@component('mail::message')
# Noticia importante
# Hola {{ $usuario->name }}

{!! $contenido !!}

@component('mail::button', ['url' => config('app.url') ])
Ir al blog
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
