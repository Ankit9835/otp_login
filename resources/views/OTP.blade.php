@component('mail::message')
# Introduction

Your OTP Is {{ $OTP }}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
