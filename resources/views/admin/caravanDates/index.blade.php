@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div>
                <x-nav-link
                        href="{{ route('admin.caravanDates.create') }}"
                        class="btn"
                        icon="far fa-plus-square"
                        text="Neueintrag"
                />
            </div>
            <div></div>
        </div>
        <x-form class="inline-form ml-5" method="get" id="frmFilter" name="frmFilter"
                action="{{ route('admin.caravanDates.index') }}"
        >
            <x-form-select
                    name="caravan"
                    class="inline-block filter"
                    :options="$caravanOptions"
                    :default="$caravan"
                    floating
            />
            <x-form-select
                    name="dublicate"
                    class="inline-block filter"
                    :options="$dublicateOptions"
                    :default="$dublicate"
                    floating
            />
            <x-form-select
                    name="year"
                    class="inline-block filter"
                    :options="$yearOptions"
                    :default="$year"
                    floating
            />
            <x-form-select
                    name="month"
                    class="inline-block filter d-none"
                    :options="$monthOptions"
                    :default="$month"
                    floating
            />
            <button class="btn btn-reset inline">Reset</button>
        </x-form>
        {{ $data->appends($queryString)->links() }}
        <table class="table w-full">
            <tr>
                <th>Kennzeichen</th>
                <th class="hidden md:table-cell">Länge</th>
                <th>Von</th>
                <th>Bis</th>
                <th class="hidden md:table-cell">Tage</th>
                <th class="hidden md:table-cell">Preis</th>
                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td>
                        <a class="carnumber cursor-pointer" href="{{ route('admin.caravanDates.show', ['caravanDate' => $item]) }}">
                            {{ $item->caravan->carnumber }}
                        </a>
                    </td>

                    <td class="hidden md:table-cell">{{ $item->caravan->carlength }} m</td>
                    <td>{{ $item->from->format('d.m.Y') }}</td>
                    <td>{{ $item->until->format('d.m.Y') }}</td>
                    <td class="hidden md:table-cell">{{ $item->days }}</td>
                    <td class="hidden md:table-cell">{{ $item->price }} €</td>

                    <td>
                        <x-nav-link href="{{ route('admin.caravanDates.edit', $item) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">Edit</x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('admin.caravanDates.destroy', ['caravanDate' => $item]) }}" class="inline-block m-0 p-0">
                            @method('delete')
                            <x-form-submit icon="fas fa-trash-alt" class="btn-red">Löschen</x-form-submit>
                        </x-form>
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="text-right mr-5 mt-3">
            <span class="text-red-500 font-extrabold">Summe Einnahmen {{ $priceTotal }} €</span>
        </div>

        {{ $data->appends($queryString)->links() }}
    </div>
@endsection

@push('inline-scripts')
    <script>
	    const frm = document.frmFilter,
		    filter = (e) => {
			    e.stopPropagation()
			    let el = e.target;
			    console.info(el.name)
				if('' === el.value && ['year','month'].indexOf(el.name) === -1) {
					return;
				}
				switch (el.name) {
					case 'caravan':
						frm.dublicate.value = '';
						frm.year.value = '';
						frm.month.value = '';
						break
					case 'dublicate':
						frm.caravan.value = '';
						frm.year.value = '';
						frm.month.value = '';
						break
					case 'year':
						if(frm.year.value === '') {
							frm.month.value = '';
						}
						frm.caravan.value = '';
						frm.dublicate.value = '';
						$(frm.month).show();
						break
					case 'month':
						frm.caravan.value = '';
						frm.dublicate.value = '';
						break
				}
				frm.submit()
            },
            reset = (e) => {
			    e.preventDefault()
                frm.caravan.value = '';
                frm.dublicate.value = '';
                frm.year.value = '';
                frm.month.value = '';
                $(frm.month).hide();
				frm.submit()
            };

		frm.querySelectorAll('.filter').forEach(item => {
			item.onchange = filter
        })
	    frm.querySelector('.btn-reset').onclick = reset
    </script>
@endpush
