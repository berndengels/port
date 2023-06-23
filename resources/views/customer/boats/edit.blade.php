@extends('layouts.main')

@section('main')
	<div>
		<x-btn-back :route="route('customer.boats.index')"/>
		<x-form method="post" :action="route('customer.boats.update', $boat)" class="w-half mt-3">
			@method('put')
			@bind($boat)
			<x-form-select name="type" label="Typ" :options="$types" required/>
			<x-form-input name="name" label="Boots Name" required/>
			<x-form-input name="length" type="number" step="0.1" min="1" label="Boots Länge" required/>
			<x-form-input name="width" type="number" step="0.1" min="1" label="Boots Breite"/>
			<x-form-input name="weight" type="number" min="1" label="Boots Gewicht in Kg"
						  placeholder="Gewicht in Kilogramm"/>
			<x-form-input name="board_height" type="number" min="0" step="0.1" label="Bord Höhe über Wasserlinie"
						  placeholder="Bord Höhe über Wasserlinie"/>
			<x-form-input name="mast_length" type="number" step="1" min="0" label="Mastlänge"/>
			<x-form-input name="mast_weight" type="number" step="1" min="0" label="Mastgewicht in Kg"
						  placeholder="Gewicht in Kilogramm"/>
			<x-form-input name="draft" type="number" step="0.1" min="0.1" label="Tiefgang"/>
			<x-form-input name="length_waterline" type="number" step="0.1" min="0.1" label="Länge Wasserlinie"/>
			<x-form-input name="length_keel" type="number" step="0.1" min="0" label="Kiellänge"/>
			@endbind
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">Speichern</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection
