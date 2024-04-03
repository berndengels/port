@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.configSaisonDates.' . (isset($route) ? $route : 'index')) }}"/>
		<x-form method="post" :action="route('admin.configSaisonDates.update', $configSaisonDate)" class="w-half mt-3">
			@method('put')
			@bind($configSaisonDate)
			<x-form-input id="name" name="name" label="Name" placeholder="Wie heißt die Saison?" required/>
			<x-form-input type="date" id="from" name="from" label="Von" :bind="false"
						  default="{{ $configSaisonDate->validFrom }}" required/>
			<x-form-input type="date" id="until" name="until" label="Bis" :bind="false"
						  default="{{ $configSaisonDate->validUntil }}" required/>
			@endbind
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection

