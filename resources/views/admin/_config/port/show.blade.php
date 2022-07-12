@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            @if(!$data)
            <div>
                <x-nav-link
                        href="{{ route('admin.config.port.create') }}"
                        class="btn"
                        icon="far fa-plus-square"
                        text="Neueintrag"
                />
            </div>
            @else
            <div>
                <table class="table table-striped">
                    <tr>
                        <th>Name</th>
                        <td>{{ $data->name }}</td>
                    </tr>
                    <tr>
                        <th>Adresse</th>
                        <td>{{ $data->postcode }} {{ $data->location }}, {{ $data->street }}</td>
                    </tr>
                    <tr>
                        <th>Fon</th>
                        <td>{{ $data->fon }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $data->email }}</td>
                    </tr>
                    <tr>
                        <th>Latitude</th>
                        <td>{{ $data->lat }}</td>
                    </tr>
                    <tr>
                        <th>Longitude</th>
                        <td>{{ $data->lng }}</td>
                    </tr>
                </table>
                <div class="mt-5">
                    <x-nav-link href="{{ route('admin.config.port.edit', $data) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">
                        <span class="hidden md:visible">Edit</span>
                    </x-nav-link>
                    <x-form action="{{ route('admin.config.port.destroy', $data) }}"
                            class="inline ml-5 p-0">
                        @method('delete')
                        <x-form-submit icon="inline fas fa-trash-alt" inline class="mt-0 btn-red delSoft">
                        <span class="hidden md:visible">
                            Löschen
                        </span>
                        </x-form-submit>
                    </x-form>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

