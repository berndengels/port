@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back route="{{ route('admin.configEntities.index') }}"/>
		<x-form method="post" :action="route('admin.configEntities.update', $configEntity)" class="w-half mt-3">
			@method('put')
			@bind($configEntity)
			<x-form-select
					name="model"
					label="Entity Model"
					:options="$modelOptions"
					class="flexy"
			/>
			<x-form-select
					name="priceComponents[]"
					label="Preis-Komponenten"
					:options="$optionsPriceComponents"
					class="flexy"
					size="10"
					multiple
					many-relation
			/>
			@endbind
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection

