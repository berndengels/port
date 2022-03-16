@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div>
                <x-nav-link
                    href="{{ route('admin.houseboatModels.create') }}"
                    class="btn"
                    icon="far fa-plus-square"
                    text="Neueintrag"
                />
            </div>
            <div></div>
        </div>
        @if($data && $data->count())
        {{ $data->links() }}
        <table class="table w-full mt-3">
            <tr>
                <th class="hidden md:table-cell">ID</th>
                <th>Name</th>
                <th class="hidden md:table-cell">Fläche</th>
                <th class="hidden md:table-cell">Stockwerke</th>
                <th class="hidden md:table-cell">max. Personen</th>
                <th class="hidden md:table-cell">Hauptsaison</th>
                <th class="hidden md:table-cell">Zwischensaison</th>
                <th class="hidden md:table-cell">Nebensaison</th>

                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td class="hidden md:table-cell">{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td class="hidden md:table-cell">{{ $item->space }} m²</td>
                    <td class="hidden md:table-cell">{{ $item->floors }}</td>
                    <td class="hidden md:table-cell">{{ $item->sleeping_places }}</td>
                    <td class="hidden md:table-cell">{{ $item->peak_season_price }} €</td>
                    <td class="hidden md:table-cell">{{ $item->mid_season_price }} €</td>
                    <td class="hidden md:table-cell">{{ $item->low_season_price }} €</td>
                    <td>
                        <x-nav-link href="{{ route('admin.houseboatModels.edit', $item) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">
                            <span class="hidden md:visible">Edit</span>
                        </x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('admin.houseboatModels.destroy', $item) }}"
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
        @else
            <h1 class="m-5">Keine Daten vorhanden</h1>
        @endif
    </div>
@endsection
