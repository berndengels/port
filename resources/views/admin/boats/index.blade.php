@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div>
                <x-nav-link
                    href="{{ route('admin.boats.create') }}"
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
                <th>Typ</th>
                <th class="hidden md:table-cell">Eigner</th>
                <th>Fon</th>
                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td class="hidden md:table-cell">{{ $item->id }}</td>
                    <td>{{ $item->boat_name }}</td>
                    <td>{{ $item->boat_type }}</td>
                    @if($item->customer)
                    <td class="hidden md:table-cell"><a href="mailto:{{ $item->customer ? $item->customer->email : ''}}" target="_blank">{{ $item->customer ? $item->customer->name : '' }}</a></td>
                    <td class="hidden md:table-cell">
                        @if($item->customer && $item->customer->fonLink)
                        <a href="tel:{{ $item->customer->fonLink }}" target="_blank">
                            <i class="fas fa-phone"></i>
                            <span>{{ $item->customer->fon }}</span>
                        </a>
                        @else
                        <br>
                        @endif
                    </td>
                    @endif
                    <td>
                        <x-nav-link href="{{ route('admin.boats.edit', $item) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">
                            <span class="hidden md:visible">Edit</span>
                        </x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('admin.boats.destroy', $item) }}"
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
