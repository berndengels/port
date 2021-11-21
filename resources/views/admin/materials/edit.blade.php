@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link :href="route('admin.materials.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form method="post" :action="route('admin.materials.update', $material)" class="frm-admin w-full lg:w-2/3">
            @method('put')
            @bind($material)
            <x-form-select name="material_category_id" label="Kategorie" :options="$categories" required />
            <x-form-input name="name" label="Name" required />

            <x-form-group class="frm-group w-full" label="Preis per Maßeinheit" inline>
                <x-form-input class="w-1/2" type="number" step="0.1" name="price_per_unit" required />
                <x-form-select class="w-1/2" name="price_type_id" :options="$priceTypes" required />
            </x-form-group>

            <x-form-group class="frm-group w-full" label="Material Ergiebigkeit: pro Maßeinheit benötigte Menge an Material in einer bestimmten Maßeinheit" inline>
                <x-form-select class="" name="fertility_per" :options="$fertilityPers" label="pro" inline
                     help="pro Maßeinheit (Fläche, Länge, Volumen etc)"
                />
                <x-form-input class="sm:w-full md:w-32" type="number" step="0.001" name="fertility" label="schafft man" inline
                     help="benötigt man soundsoviel Material"
                />
                <x-form-select class="" name="fertility_unit" :options="$fertilityUnits" inline
                     help="in folgender Maßeinheit"
                />
            </x-form-group>
            @endbind
            <div class="mt-2">
                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-save">Speichern</x-form-submit>
            </div>
        </x-form>
    </div>
    <x-tooltip id="tooltip" />
@endsection

@push('inline-scripts')
    <script>
		Tooltip.prepare('i.help')
    </script>
@endpush

