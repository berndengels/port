@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div>
                <x-nav-link
                    href="{{ route('admin.houseboatOwners.create') }}"
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
                <th>Email</th>
                <th>Fon</th>
                <th class="hidden md:table-cell">PLZ</th>
                <th class="hidden md:table-cell">Ort</th>
                <th class="hidden md:table-cell">Straße</th>

                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td class="hidden md:table-cell">{{ $item->id }}</td>
                    <td><a href="{{ route('admin.houseboatOwners.show', $item) }}">{{ $item->name }}</a></td>
                    <td><a href="mailto:{{ $item->email }}">{{ $item->email }}</a></td>
                    <td><a href="tel:{{ $item->fon }}">{{ $item->fon }}</a></td>
                    <td class="hidden md:table-cell">{{ $item->postcode }} m²</td>
                    <td class="hidden md:table-cell">{{ $item->city }}</td>
                    <td class="hidden md:table-cell">{{ $item->street }}</td>
                    <td>
                        <x-nav-link href="{{ route('admin.houseboatOwners.edit', $item) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">
                            <span class="hidden md:visible">Edit</span>
                        </x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('admin.houseboatOwners.destroy', $item) }}"
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
