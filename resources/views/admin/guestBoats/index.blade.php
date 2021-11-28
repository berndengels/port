@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div>
                <x-nav-link
                    href="{{ route('admin.guestBoats.create') }}"
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
                <th>Bootsname</th>
                <th>Länge</th>
                <th class="hidden md:table-cell">Heimatfafen</th>
                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td class="hidden md:table-cell">{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->length }} m</td>
                    <td>{{ $item->home_port }}</td>
                    <td>
                        <x-nav-link href="{{ route('admin.guestBoats.edit', $item) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">
                            <span class="hidden md:visible">Edit</span>
                        </x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('admin.guestBoats.destroy', $item) }}"
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
