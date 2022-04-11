@extends('layouts.main')

@section('main')
    <div class="p-6">
        <x-nav-link href="{{ route('admin.houseboatDates.index', ['saison' => $modus ?? null]) }}" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <x-form name="frm" method="post" :action="route('admin.houseboatDates.update', $houseboatDate)" class="w-full lg:w-1/2">
            @method('put')
            <div class="mt-5">
                <span class="text-2xl text-blue-900">Hausboot: {{ $boatDate->houseboat->name }}</span>
            </div>
            <div class="mt-5">
                <span class="text-2xl text-blue-900">Gast: {{ $boatDate->customer->name }}, {{ $boatDate->customer->email }}</span>
            </div>
            @bind($houseboatDate)
            <x-form-select class="calc" class="houseboat" id="houseboat_id" name="houseboat_id" label="Hausboot" :options="$houseboatOptions" required />
            <x-form-input class="calc" id="from" name="from" type="date" label="Von" required />
            <x-form-input class="calc" id="until" name="until" type="date" label="Bis" required />
            <x-form-input  id="price" name="price" type="number" min="0" label="Gesamt-Preis" required />
            <x-form-input type="hidden" name="prices" />
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
		    const calcUrl = "{{ route('admin.boatDates.price.calculate') }}";
		    Prices.boatDates.calculate(document.frm, calcUrl);
	    })
    </script>
@endpush
