@extends('layouts.main')
@php
use Illuminate\Support\Str;
@endphp
@section('main')
    <div>
        <x-btn-back route="{{ route('admin.boatDates.index') }}" />
        <x-form name="frm" method="post" action="{{ route('admin.boatDates.store') }}" class="w-half mt-3">
            <x-form-checkbox id="is_paid" name="is_paid" label="Ist Bezahlt" class="mb-0 pb-0" />
            <x-form-select class="calc" class="boat" id="boat_id" name="boat_id" label="Boot" :options="$boatOptions"
                           required/>
            <x-form-select class="calc" id="modus" name="modus" label="Art" :options="$datesModi" required/>
            <x-form-input class="calc" id="from" name="from" type="date" label="Von" required/>
            <x-form-input class="calc" id="until" name="until" type="date" label="Bis" required/>

			@if($priceComponents->count() > 0)
				@foreach($priceComponents as $pc)
					<div class="mt-3 wrapper{{ ucfirst(Str::camel($pc->key)) }}">
						<x-form-checkbox class="calc" id="{{ $pc->key }}" name="{{ $pc->key }}" label="{{ $pc->name }}"/>
						@if($pc->priceType->is_time)
							<div class="durationWrapper d-none">
								<x-form-input class="calc duration" disabled id="duration_{{ $pc->key }}" name="duration_{{ $pc->key }}" type="number" step="0.1" min="0" label="Arbeitsdauer in {{ $pc->priceType->name_units }}" placeholder="Arbeitsdauer {{ $pc->priceType->name_units }}" />
							</div>
						@endif
					</div>
				@endforeach
			@endif

			<br>
            <x-form-input id="price" name="price" type="number" min="0" label="Gesamt-Preis" required/>
            <x-form-input type="hidden" name="prices"/>

			<x-form-input id="type" name="type" type="text" label="Boots-Typ" disabled/>
            <x-form-input id="length" name="length" type="number" min="0" label="Länge" disabled/>
            <x-form-input id="width" name="width" type="number" min="0" step="0.1" label="Breite" disabled/>
            <x-form-input id="weight" name="weight" type="number" min="0" label="Gewicht in Kg" disabled/>
            <x-form-input id="mast_length" name="mast_length" type="number" min="0" label="Mastlänge" disabled/>
            <x-form-input id="mast_weight" name="mast_weight" type="number" min="0" label="Mastgewicht in Kg" disabled/>

            <div class="mt-2">
                <x-form-submit class="btn-sm btn-primary" icon="fas fa-save">
                    Speichern
                </x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

@push('inline-scripts')
<script>
const defaultFromWinter = "{{ $defaultFromWinter }}",
	defaultUntilWinter  = "{{ $defaultUntilWinter }}",
	defaultFromSummer   = "{{ $defaultFromSummer }}",
	defaultUntilSummer  = "{{ $defaultUntilSummer }}",
	toHides = ['.wrapperMastCrane','#mast_length','#mast_weight'],
	handleCheck = (e) => {
		let $el = $(e.target),
			$wrapper = $el.parent().next('.durationWrapper'),
			$duratiun = $wrapper.find('.duration')
		;

		if($wrapper.length > 0) {
			if($el.is(':checked')) {
				$wrapper.removeClass('d-none');
				$duratiun.removeAttr('disabled')
			} else {
				$wrapper.addClass('d-none');
				$duratiun.attr('disabled', true)
			}
		}
	}
;

$(document).ready(() => {
	const calcUrl = "{{ route('admin.boatDates.price.calculate') }}",
		autofillParams = {
			type: document.frm.type,
			length: document.frm.length,
			width: document.frm.width,
			weight: document.frm.weight,
			mast_length: document.frm.mast_length,
			mast_weight: document.frm.mast_weight,
		};

	if ($('#boat_id').val()) {
		MyForm.autofill("/admin/boats/" + $('#boat_id').val(), autofillParams, toHides);
	}

	$('#modus').change(e => {
		switch(e.target.value) {
			case 'summer':
				$('#from').val(defaultFromSummer);
				$('#until').val(defaultUntilSummer);
				break;
			case 'winter':
				$('#from').val(defaultFromWinter);
				$('#until').val(defaultUntilWinter);
				break;
		}
	});

	$('#boat_id').change(e => {
		let $el = $(e.target);
		if ($el.val() && "" !== $el.val()) {
			MyForm.autofill("/admin/boats/" + $el.val(), autofillParams, toHides);
		}
	});
	$('.calc[type="checkbox"]').change(e => {
		handleCheck(e);
	})

	Prices.calculate(document.frm, calcUrl);
});
</script>
@endpush
