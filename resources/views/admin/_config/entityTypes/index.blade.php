@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div>
                <x-nav-link
                        href="{{ route('admin.config.entityTypes.create') }}"
                        class="btn"
                        icon="far fa-plus-square"
                        text="Neueintrag"
                />
            </div>
            <div></div>
        </div>
        {{ $data->links() }}
        <table class="table w-auto mt-3 mx-2 dt-left">
            <tr>
                <th class="hidden md:table-cell">ID</th>
                <th>Model</th>
                <th>Komponenten</th>
                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
                <tr class="bottomBorder">
                    <td class="hidden md:table-cell">{{ $item->id }}</td>
                    <td title="{{ $item->model }}">{{ __($item->model) }}</td>
                    <td>
                        @if($item->priceComponents->count() > 0)
                        <ul>
                            @foreach ($item->priceComponents as $component)
                                <li>{{ $component->name }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </td>
                    <td>
                        <x-nav-link href="{{ route('admin.config.entityTypes.edit', $item) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">
                            <span class="hidden md:visible">Edit</span>
                        </x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('admin.config.entityTypes.destroy', $item) }}"
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
