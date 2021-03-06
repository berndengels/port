@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.boats.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form name="frm" method="post" :action="route('admin.boats.update', $boat)" class="w-full lg:w-1/2">
            @method('put')
            @bind($boat->customer)
            <x-form-input name="name" label="Eigner" required autocomplete="off" />
            <ul id="customers" class="hidden w-full autocomplete"></ul>
            <x-form-input name="email" label="Email" />
            <x-form-input name="fon" label="Telefon" />
            <x-form-input name="state" label="Bundesland" />
            @endbind

            @bind($boat)
            <x-form-select name="boat_type" label="Typ" :options="$types" required />
            <x-form-input name="boat_name" label="Boots Name" required />
            <x-form-input name="length" type="number" step="0.1" min="1" label="Boots Länge" required />
            <x-form-input name="width" type="number" step="0.1"  min="1" label="Boots Breite" />
            <x-form-input name="weight" type="number" min="1" label="Boots Gewicht in Kg" placeholder="Gewicht in Kilogramm" />
            <x-form-input name="board_height" type="number" min="0" step="0.1" label="Bord Höhe über Wasserlinie" placeholder="Bord Höhe über Wasserlinie" />
            <x-form-input name="mast_length" type="number" step="1" min="0" label="Mastlänge" />
            <x-form-input name="mast_weight" type="number" step="1" min="0" label="Mastgewicht in Kg" placeholder="Gewicht in Kilogramm" />
            <x-form-input name="draft" type="number" step="0.1" min="0.1" label="Tiefgang" />
            <x-form-input name="length_waterline" type="number" step="0.1" min="0.1" label="Länge Wasserlinie" />
            <x-form-input name="length_keel" type="number" step="0.1" min="0" label="Kiellänge" />
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
@endsection

@push('inline-scripts')
    <script>
	    $(document).ready(() => {
		    const frm = document.frm,
			    options = {!! $customerOptions !!},
			    bindings = {
				    name: frm.name,
				    email: frm.email,
				    fon: frm.fon,
				    state: frm.state,
			    };
		    MyForm.autocomplete(".autocomplete", frm.name, options, 'name', bindings);
	    })
    </script>
@endpush
