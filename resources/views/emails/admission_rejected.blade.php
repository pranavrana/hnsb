@component('mail::message')
Hello {{ $user->name }}, this mail is to notify you that your admission application has been rejected and below is the reason for rejection.
@component('mail::panel')
{{$user->admission_rejection_reason}}
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
