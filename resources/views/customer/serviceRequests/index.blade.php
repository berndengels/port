@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-4">
            <div>
                <x-nav-link
                        href="{{ route('customer.serviceRequests.create') }}"
                        class="btn"
                        icon="far fa-plus-square"
                        text="Neueintrag"
                />
            </div>
            <div></div>
        </div>
        @if($data->count() > 0)
        {{ $data->links() }}
        <table class="table w-full mt-3">
            <tr>
                <th>ID</th>
                <th >Boot</th>
                <th class="hidden md:table-cell">Beschreibung</th>
                <th>Bis</th>
                <th>Erledigt</th>
                <th>Am</th>
                <th>Erstellt</th>
                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->boat->boat_name }}</td>
                    <td class="hidden md:table-cell">
                        <a href="{{ route('customer.serviceRequests.show', $item) }}">{{ $item->description }}</a>
                    </td>
                    <td>{{ $item->done_until->format('d.m.Y') }}</td>
                    <td>{{ $item->done ? 'Ja' : 'Nein' }}</td>
                    <td>{{ $item->done_at ? $item->done_at->format('d.m.Y H:i') : '' }}</td>
                    <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <x-nav-link href="{{ route('customer.serviceRequests.edit', $item) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">
                            <span class="hidden md:visible">Edit</span>
                        </x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('customer.serviceRequests.destroy', $item) }}"
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
            <h3 class="m-5 text-lg text-blue-900">Keine Daten vorhanden</h3>
        @endif
    </div>
@endsection
