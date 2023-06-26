@extends('layouts.main')

@section('main')
	<div>
		<h3 class="m-5 text-2xl font-bold page-message">@isset($message)
				{{ $message }}
			@else
				Keine Daten vorhanden
			@endisset</h3>
	</div>
@endsection
