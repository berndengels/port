@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div class="float-left">
                <x-nav-link
                        href="{{ route('admin.caravanDates.create') }}"
                        class="btn"
                        icon="far fa-plus-square"
                        text="Neueintrag"
                />
            </div>
            @if($data->count() > 0 && $year || $month)
            <div class="float-right">
                <a href="{{ route('admin.caravan.price.excel', ['year' => $year, 'month' => $month]) }}"
                        class="btn btn-second ml-0 my-2 no-hide-text"
                        target="_blank"
                        title="Excel-Datei runterladen"
                ><i class="far fa-file-excel"></i>Excel Download</a>

                <x-form method="post" :action="route('admin.caravanDates.sendExcel')" class="mt-0 pt-0">
                    <x-form-input type="hidden" name="year" :default="$year" />
                    <x-form-input type="hidden" name="month" :default="$month" />
                    <x-form-input type="email" name="email" required autocomplete="email" placeholder="Email-Adresse" />
                    <x-form-submit name="submit" inline class="btn btn-second mt-3" icon="fas fa-shipping-fast">Sende Excel</x-form-submit>
                </x-form>
            </div>
            @endif
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
            @if($year)
            <x-form-select
                    name="month"
                    class="inline-block filter"
                    :options="$monthOptions"
                    :default="$month"
                    floating
            />
            @endif
            <button class="btn btn-reset inline">Reset</button>
        </x-form>
        {{ $data->appends($queryString)->links() }}
        <table class="table w-full">
            <tr>
                <th>Kennzeichen</th>
                <th class="hidden md:table-cell">L??nge</th>
                <th>Von</th>
                <th>Bis</th>
                <th class="hidden md:table-cell">Tage</th>
                <th class="hidden md:table-cell">Preis</th>
                <th>Bezahlt</th>
                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td><span class="carnumber cursor-pointer">{{ $item->caravan->carnumber }}</span></td>
                    <td class="hidden md:table-cell">{{ $item->caravan->carlength }} m</td>
                    <td>{{ $item->from->format('d.m.y') }}</td>
                    <td>{{ $item->until->format('d.m.y') }}</td>
                    <td class="hidden md:table-cell">{{ $item->days }}</td>
                    <td class="hidden md:table-cell">
                        <a class="cursor-pointer" href="{{ route('admin.caravanDates.show', ['caravanDate' => $item]) }}">
                            {{ $item->price }} ???
                        </a>
                    </td>
                    <td rel="{{ $item->id }}">{!! $item->icon('is_paid') !!}</td>
                    <td>
                        <x-nav-link href="{{ route('admin.caravanDates.edit', $item) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">
                            <span class="hidden md:visible">Edit</span>
                        </x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('admin.caravanDates.destroy', ['caravanDate' => $item]) }}"
                                class="m-0 p-0">
                            @method('delete')
                            <x-form-submit icon="fas fa-trash-alt" inline class="mt-0 btn-red delSoft">
                                <span class="hidden md:visible">
                                    L??schen
                                </span>
                                </x-form-submit>
                        </x-form>
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="text-center mr-5 mt-3">
            <span class="text-red-500 font-extrabold">Summe Einnahmen {{ $priceTotal }} ???</span>
        </div>

        {{ $data->appends($queryString)->links() }}
    </div>
    <x-tooltip id="tooltip" />
@endsection

@push('inline-scripts')
    <script>
	    Edit.toggle("/admin/caravanDates/toggle","is_paid");
	    const frm = document.frmFilter,
		    filter = (e) => {
			    let el = e.target;
			    console.info(el.name);
				if('' === el.value && ['year','month'].indexOf(el.name) === -1) {
					return;
				}
				switch (el.name) {
					case 'caravan':
						frm.dublicate.value = '';
						frm.year.value = '';
						if(frm.month) {
							frm.month.value = '';
                        }
						break;
					case 'dublicate':
						frm.caravan.value = '';
						frm.year.value = '';
						if(frm.month) {
							frm.month.value = '';
						}
						break;
					case 'year':
						if(frm.year.value === '' && frm.month) {
							frm.month.value = '';
						}
						frm.caravan.value = '';
						frm.dublicate.value = '';
						break;
					case 'month':
						frm.caravan.value = '';
						frm.dublicate.value = '';
						break
				}
				frm.submit()
            },
            reset = (e) => {
			    e.preventDefault();
                frm.caravan.value = '';
                frm.dublicate.value = '';
                frm.year.value = '';
                frm.month.value = '';
                $(frm.month).hide();
				frm.submit()
            };

		frm.querySelectorAll('.filter').forEach(item => {
			item.onchange = filter
        });
	    frm.querySelector('.btn-reset').onclick = reset;

	    const routePrefix = "{{ route('admin.car.info') }}";
	    Car.info(routePrefix, '.carnumber', '#tooltip')
    </script>
@endpush
