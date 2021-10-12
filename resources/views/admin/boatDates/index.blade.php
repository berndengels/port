@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div>
                <x-nav-link
                    href="{{ route('admin.boatDates.create', ['modus' => $modus]) }}"
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
                    <td>{{ $item->boat->boat_name }}</td>
                    <td>{{ $item->from }}</td>
                    <td>{{ $item->until }}</td>
                    <td class="hidden md:table-cell">
                        @if($item->boat->customer->email)
                            <a href="mailto:{{ $item->boat->customer->email }}" target="_blank">
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
        </table>
        {{ $data->links() }}
    </div>
@endsection
