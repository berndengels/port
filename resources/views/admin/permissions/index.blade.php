@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div>
                <x-nav-link
                        href="{{ route('admin.permissions.create') }}"
                        class="btn"
                        icon="far fa-plus-square"
                        text="Neueintrag"
                />
            </div>
            <div></div>
        </div>
        <div>
            <x-search-filter name="name" action="{{ route('admin.permissions.index') }}" placeholder="Suche Permissions" />
        </div>
        {{ $data->links() }}
        <table class="table w-full mt-3">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th class="hidden md:table-cell">Guard Name</th>
                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name ?? null }}</td>
                    <td class="hidden md:table-cell">{{ $item->guard_name }}</td>
                    <td>
                        <x-nav-link href="{{ route('admin.permissions.edit', $item) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">
                            <span class="hidden md:visible">Edit</span>
                        </x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('admin.permissions.destroy', $item) }}"
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
