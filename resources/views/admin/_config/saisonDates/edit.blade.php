@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.config-saisonDates.' . (isset($route) ? $route : 'index')) }}"/>
		<x-form method="post" :action="route('admin.config-saisonDates.update', $saisonDate)" class="w-half mt-3">
			@method('put')
			@bind($saisonDate)
			<x-form-input id="name" name="name" label="Name" placeholder="Wie heißt die Saison?" required/>
			<x-form-input type="date" id="from" name="from" label="Von" :bind="false"
						  default="{{ $saisonDate->validFrom }}" required/>
			<x-form-input type="date" id="until" name="until" label="Bis" :bind="false"
						  default="{{ $saisonDate->validUntil }}" required/>
			@endbind
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection

