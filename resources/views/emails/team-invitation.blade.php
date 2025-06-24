@component('mail::message')
# You've Been Invited to Join {{ $client->name }}

{{ $inviter->name }} has invited you to join their team on {{ config('app.name') }} as a {{ $role }}.

@component('mail::button', ['url' => route('register', ['token' => $token])])
Accept Invitation
@endcomponent

If you did not expect to receive this invitation, you can ignore this email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent