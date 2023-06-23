@extends('layouts.main')

@section('main')
	<div class="container m-3">
		<h3 class="text-success">Ihre Nachricht wurde erfolgreich verschickt</h3>
		<div class="row">
			<div class="col-2">Name</div>
			<div class="col-auto">{{ $contact->name }}</div>
		</div>
		<div class="row">
			<div class="col-2">Email</div>
			<div class="col-auto">{{ $contact->email }}</div>
		</div>
		<div class="row">
			<div class="col-2">Betreff</div>
			<div class="col-auto">{{ $contact->subject }}</div>
		</div>
		<div class="row">
			<div class="col-2">Nachricht</div>
			<div class="col-auto">{{ $contact->message }}</div>
		</div>
	</div>
@endsection
