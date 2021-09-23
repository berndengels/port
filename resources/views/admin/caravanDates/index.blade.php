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
        <x-form class="inline-form ml-5" method="get" name="frmFilter" action="{{ route('admin.caravanDates.index') }}">
            @csrf
            <x-form-select
                    name="caravan"
                    class="inline-block"
                    :options="$caravanOptions"
                    :default="$caravanId"
                    placeholder="Filter nach Kennzeichen"
                    onchange="document.frmFilter.submit()"
                    floating
            />
            <button class="btn btn-reset inline" onclick="document.frmFilter.caravan.value = ''">Reset</button>
        </x-form>
        {{ $data->links() }}
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
                        <a class="carnumber cursor-pointer" href="{{ route('admin.caravanDates.show', ['caravanDate' => $item->id]) }}">{{ $item->caravan->carnumber }}</a>
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

        {{ $data->links() }}
    </div>
@endsection
