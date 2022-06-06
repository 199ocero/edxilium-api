@component('mail::message')
# Instructor Credentials

After you verified your email address, please use this email to reset your password:

Email: {{ $email }}
<br>
<br>
@component('mail::button', ['url' => env('FRONTEND_URL') . 'password/reset'])
    Reset Password
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
