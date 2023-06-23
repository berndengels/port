@component('mail::message')
	## Neue Kontakt Anfrage
	- Eingang: {{ $contact->created_at->format('d.m.Y H:i') }}
	- Name: {{ $contact->name }}
	- Email: <{{ $contact->email }}>
	- Betreff: {{ $contact->subject }}
	### Nachricht
	{{ $contact->message }}
@endcomponent
