@extends('layouts.main')

@section('main')
    <div class="mb-5">
        <div id="frm">
            <div>
                <h5>Liegeplatz Gruppen Eingeschaften</h5>
                <x-form class="m-3">
                    <x-form-input id="prefix" name="prefix" label="Prefix" />
                    <x-form-input id="start" name="start" type="number" step="1" min="1" label="Startnummer" />
                    <x-form-input id="end" name="end" type="number" step="1" min="1" label="Endnummer" />
                    <x-form-input id="width" name="width" type="number" step="0.1" min="1" label="Breite" />
                    <x-form-input id="length" name="length" type="number" step="0.1" min="1" label="Länge" />
                    <x-form-input id="dailyPrice" name="dailyPrice" type="number" step="1" min="1" label="Tagespreis" />
                </x-form>
            </div>
        </div>
        <div id="mapBerths"></div>
        <button id="storeBerths" class="btn btn-save">Alle Daten Speichern</button>
    </div>
    <div>
        <div class="index-header mt-3">
            <div>
                <x-nav-link
                    href="{{ route('admin.guestBoatBerths.create') }}"
                    class="btn"
                    icon="far fa-plus-square"
                    text="Neueintrag"
                />
            </div>
            <div></div>
        </div>
        {{ $data->links() }}
        <table class="table w-full mt-3">
            <tr>
                <th class="hidden md:table-cell">ID</th>
                <th>Nummer</th>
                <th class="hidden md:table-cell">Länge</th>
                <th class="hidden md:table-cell">Breite</th>
                <th>Tagespreis</th>
                <th class="hidden md:table-cell">Lat</th>
                <th class="hidden md:table-cell">Lng</th>
                <th>Aktiv</th>
                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td class="hidden md:table-cell">{{ $item->id }}</td>
                    <td>{{ $item->number }}</td>
                    <td class="hidden md:table-cell">{{ $item->length }} m</td>
                    <td class="hidden md:table-cell">{{ $item->width }} m</td>
                    <td>{{ $item->daily_price }}</td>
                    <td class="hidden md:table-cell">{{ $item->lat }}</td>
                    <td class="hidden md:table-cell">{{ $item->lng }}</td>
                    <td rel="{{ $item->id }}">{!! $item->icon('enabled') !!}</td>

                    <td>
                        <x-nav-link href="{{ route('admin.guestBoatBerths.edit', $item) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">
                            <span class="hidden md:visible">Edit</span>
                        </x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('admin.guestBoatBerths.destroy', $item) }}"
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
        </table>

        {{ $data->links() }}
    </div>
@endsection

@push('inline-scripts')
    <script>
        window.onload = () => {
	        Edit.toggle("/admin/guestBoatBerths/toggle","enabled");
	        Geo.berthMap('mapBerths','#storeBerths');
        }
    </script>
@endpush
