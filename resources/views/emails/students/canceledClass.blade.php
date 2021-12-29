@component('mail::message')
# Olá, {{ $data['name'] }}

A aula do dia {{ $data['date'] }}, foi cancelada.

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
