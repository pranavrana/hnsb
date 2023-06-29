@component('mail::message')
# Introduction

Hello {{ $user->name }}, 
Congratulations! your admission application has been approved. Please pay college fees by 'Given Date'.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
