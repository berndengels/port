@props(['recipient'])
<div class="invoice-header row recipient {{ $class }}">
	<p>
		{{ $recipient->name }}<br>
		{{ $recipient->street }}<br>
		{{ $recipient->postcode }} {{ $recipient->city }}
	</p>
</div>
