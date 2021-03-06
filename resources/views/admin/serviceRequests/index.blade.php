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
                <th class="hidden md:table-cell">Kunde</th>
                <th>Boot</th>
                <th class="hidden md:table-cell">Beschreibung</th>
                <th>Erledigt</th>
                <!--th>Am</th-->
                <th>Erledigt bis</th>
                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td class="hidden md:table-cell">{{ $item->boat->customer->name }}</td>
                    <td>{{ $item->boat->boat_name }}</td>
                    <td class="hidden md:table-cell">{{ Str::limit($item->description, 30) }}</td>
                    <td>{{ $item->done ? 'Ja' : 'Nein' }}</td>
                    <!--td>{{-- $item->done_at ? $item->done_at->format('d.m.Y H:i') : '' --}}</td-->
                    <td>{{ $item->done_until->format('d.m.Y') }}</td>
                    <td>
                        <x-nav-link href="{{ route('admin.serviceRequests.show', $item) }}" icon="fas fa-eye" class="btn" title="Bearbeiten">
                            <span class="hidden md:visible">Show</span>
                        </x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('admin.serviceRequests.destroy', $item) }}"
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
