@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div>
                <x-nav-link
                    href="{{ route('admin.customers.create') }}"
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
                <th>Name</th>
                <th class="hidden md:table-cell">Email</th>
                <th>Bestätigt</th>
                <th>Fon</th>
                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td class="hidden md:table-cell">{{ $item->id }}</td>
                    <td><x-navlink href="{{ route('admin.customers.show', $item) }}">{{ $item->name }}</x-navlink></td>
                    <td class="hidden md:table-cell"><a href="mailto:{{ $item->email }}" target="_blank">{{ $item->email }}</a></td>
                    <td>{!! $item->icon('confirmed') !!}</td>
                    <td>
                        @if($item->fon)
                        <a href="tel:{{ $item->fonLink }}" target="_blank">
                            <i class="fas fa-phone text-blue"></i>
                            {{ $item->fon }}
                        </a>
                        @endif
                    </td>
                    <td>
                        <x-nav-link href="{{ route('admin.customers.edit', $item) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">
                            <span class="hidden md:visible">Edit</span>
                        </x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('admin.customers.destroy', $item) }}"
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
