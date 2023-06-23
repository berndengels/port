@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.config.saisonRents.index') }}"/>
		<x-form method="post" :action="route('admin.config.saisonRents.store')" class="w-half mt-3">
			<x-form-input type="text" id="key" name="key" label="Key" required placeholder="Key Name"/>
			<x-form-input type="text" id="name" name="name" label="Name" required placeholder="Saison Name"/>
			<x-form-input type="number" id="price" name="price" min="0" step="1" label="Preis pro Tag" required
						  placeholder="Preis pro Tag"/>
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection

