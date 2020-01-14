@component('mail::message')
# Introduction

Alerta de inicio de sesion: 

@component('mail::button', ['url' => '/'])
Ver Actividad
@endcomponent

La seguridad para nosotros es muy importante,<br>

{{ config('app.name') }}
@endcomponent
