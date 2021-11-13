@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div>
                <x-nav-link
                        href="{{ route('admin.materials.create') }}"
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
                <th>Art</th>
                <th>Preis-Typ</th>
                <th>Name</th>
                <th>Preis per Einheit</th>
                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->priceType->name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->price_per_unit }} €</td>
                    <td>
                        <x-nav-link href="{{ route('admin.materials.edit', $item) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">
                            <span class="hidden md:visible">Edit</span>
                        </x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('admin.materials.destroy', $item) }}"
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
