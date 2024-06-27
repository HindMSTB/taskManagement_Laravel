

@component('mail::message')
# Email Verification

Vérifier votre Email pour accéder à votre espace !

@component('mail::button', ['url' => $verificationUrl])
Vérifier Email
@endcomponent

Merci,
Hind Moustain Billah <br>

@endcomponent
