@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div></div>
            <div></div>
        </div>
        {{ $data->links() }}
        <table class="table w-full mt-3">
            <tr>
                <th>ID</th>
                <th>Kunde</th>
                <th class="hidden md:table-cell">Service</th>
                <th class="hidden md:table-cell">Beschreibung</th>
                <th>Erledigt</th>
                <th>Am</th>
                <th>Erstellt</th>
                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->customer->name }}</td>
                    <td class="hidden md:table-cell">{{ $item->service->description }}</td>
                    <td class="hidden md:table-cell">{{ $item->description }}</td>
                    <td>{{ $item->done ? 'Ja' : 'Nein' }}</td>
                    <td>{{ $item->done_at->format('d.m.Y H:i') }}</td>
                    <td>{{ $item->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <x-nav-link href="{{ route('admin.serviceRequest.edit', $item) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">
                            <span class="hidden md:visible">Edit</span>
                        </x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('admin.serviceRequest.destroy', $item) }}"
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
