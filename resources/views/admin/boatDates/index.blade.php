@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div class="float-left">
                <x-nav-link
                    href="{{ route('admin.boatDates.create', ['modus' => $saison ?? null]) }}"
                    class="btn"
                    icon="far fa-plus-square"
                    text="Neueintrag"
                />
            </div>
        @if($data->count() > 0 && $year || $month)
            <div class="float-right">
                <a href="{{ route('admin.boat.price.excel', ['year' => $year, 'month' => $month]) }}"
                   class="btn btn-second ml-0 my-2 no-hide-text"
                   target="_blank"
                   title="Excel-Datei runterladen"
                ><i class="far fa-file-excel"></i>Excel Download</a>

                <x-form method="post" :action="route('admin.boatDates.sendExcel')" class="mt-0 pt-0">
                    <x-form-input type="hidden" name="year" :default="$year" />
                    <x-form-input type="hidden" name="month" :default="$month" />
                    <x-form-input type="email" name="email" required autocomplete="email" placeholder="Email-Adresse" />
                    <x-form-submit name="submit" inline class="btn btn-second mt-3" icon="fas fa-shipping-fast">Sende Excel</x-form-submit>
                </x-form>
            </div>
        @endif
        </div>

        <x-form class="inline-form ml-5" method="get" id="frmFilter" name="frmFilter"
                action="{{ route('admin.boatDates.index') }}"
        >
            <x-form-select
                    name="boat"
                    class="inline-block filter"
                    :options="$boatOptions"
                    :default="$boat"
                    floating
            />
            <x-form-select
                    name="saison"
                    class="inline-block filter"
                    :options="$saisonOptions"
                    :default="$saison"
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
        <table class="table w-full mt-3">
            <tr>
                <th class="hidden md:table-cell">ID</th>
                <th>Boot</th>
                <th>Von</th>
                <th>Bis</th>
                <th class="hidden md:table-cell">Eigner</th>
                <th>Fon</th>
                <th>Preis</th>
                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td class="hidden md:table-cell">{{ $item->id }}</td>
                    <td><a href="{{ route('admin.boatDates.show', $item) }}">{{ $item->boat ? $item->boat->boat_name : null }}</a></td>
                    <td>{{ $item->from->format('d.m.Y') }}</td>
                    <td>{{ $item->until->format('d.m.Y') }}</td>
                    <td class="hidden md:table-cell">
                        @if($item->boat->customer->email)
                            <a href="mailto:{{ $item->boat->customer->email }}" target="_blank">
                                <i class="fas fa-at"></i>
                                {{ $item->boat->customer ? $item->boat->customer->name : '' }}
                            </a>
                        @else
                            {{ $item->boat->customer ? $item->boat->customer->name : '' }}
                        @endif
                    </td>
                    <td>
                        @if($item->boat->customer->fonLink)
                        <a href="tel:{{ $item->boat->customer->fonLink }}" target="_blank">
                            <i class="fas fa-phone"></i>
                            <span>{{ $item->boat->customer->fon }}</span>
                        </a>
                        @else
                        <br>
                        @endif
                    </td>
                    <td>{{ $item->price }} €</td>
                    <td>
                        <x-nav-link href="{{ route('admin.boatDates.edit', $item) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">
                            <span class="hidden md:visible">Edit</span>
                        </x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('admin.boatDates.destroy', $item) }}"
                                class="m-0 p-0">
                            @method('delete')
                            <x-form-submit icon="fas fa-trash-alt" inline class="mt-0 btn-red delSoft">
                                <span class="hidden md:visible">
                                    Löschen
                                </span>
                            </x-form-submit>
                        </x-form>
                    </td>
                </tr>
            @endforeach
            <tr>
                <th colspan="9">
                    <div class="mt-3 w-full text-red-700">Summe Preis: {{ $priceTotal }} €</div>
                </th>
            </tr>
        </table>
        {{ $data->appends($queryString)->links() }}
    </div>
@endsection

@push('inline-scripts')
    <script>
		const frm = document.frmFilter,
			filter = (e) => {
				let el = e.target;
				console.info(el.name);
				if('' === el.value && ['year','month'].indexOf(el.name) === -1) {
					return;
				}
				switch (el.name) {
					case 'boat':
						frm.year.value = '';
						if(frm.month) {
							frm.month.value = '';
						}
						break;
					case 'year':
						if(frm.year.value === '' && frm.month) {
							frm.month.value = '';
						}
						frm.boat.value = '';
						break;
					case 'saison':
					case 'month':
						frm.boat.value = '';
						break
				}
				frm.submit()
			},
			reset = (e) => {
				e.preventDefault();
				frm.boat.value = '';
				frm.saison.value = '';
				frm.year.value = '';
				frm.month.value = '';
				$(frm.month).hide();
				frm.submit()
			};

		frm.querySelectorAll('.filter').forEach(item => {
			item.onchange = filter
		});
		frm.querySelector('.btn-reset').onclick = reset
    </script>
@endpush
