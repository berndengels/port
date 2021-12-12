@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div>
                <x-nav-link
                        href="{{ route('admin.config.priceComponents.create') }}"
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
                <th>Betrifft</th>
                <th>Name</th>
                <th>Key</th>
                <th>Service</th>
                <th>Preis Typ</th>
                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
                <tr class="bottomBorder">
                    <td class="hidden md:table-cell">{{ $item->id }}</td>
                    <td>
                        @if($item->entities->count() > 0)
                            <ul>
                            @foreach($item->entities as $entity)
                                <li title="{{ $entity->model }}">
                                    {{ __($entity->model) }}
                                </li>
                            @endforeach
                            </ul>
                        @endif
                    </td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->key }}</td>
                    <td>{{ $item->service?->name }}</td>
                    <td>{{ $item->priceType->name }}</td>
                    <td>
                        <x-nav-link href="{{ route('admin.config.priceComponents.edit', $item) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">
                            <span class="hidden md:visible">Edit</span>
                        </x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('admin.config.priceComponents.destroy', $item) }}"
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
