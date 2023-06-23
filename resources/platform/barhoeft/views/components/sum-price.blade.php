<div class="card {{ $class ?? 'sum-price' }} draggable">
	<div class="card-header trigger">{{ $title }} @if($from)
			seit {{ $from->format('d.m.Y') }}
		@endif</div>
	<div class="card-body p-3">
		<div class="row">
			<div class="col-4">Netto</div>
			<div class="col-auto">{{ $netto }} €</div>
		</div>
		<div class="row">
			<div class="col-4">MWSt</div>
			<div class="col-auto">{{ $mwst }} €</div>
		</div>
		<div class="row">
			<div class="col-4">Brutto</div>
			<div class="col-auto">{{ $brutto }} €</div>
		</div>
	</div>
</div>
