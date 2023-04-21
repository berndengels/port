@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3 p-0">
            <div class="ms-0">
                <x-btn-create route="{{ route('admin.houseboatOwners.create') }}" />
            </div>
            <div></div>
        </div>
        {{ $data->links() }}
        <x-table :items="$data" :fields="['Name','Email','Fon','PLZ:md','Ort:md','Strasse:md']" hasActions isSmall>
            @foreach($data as $item)
                <tr>
                    @bindData($item)
                    <x-td field="name" link="{{ route('admin.houseboatOwners.show', $item) }}" />
                    <x-td field="email" link="mailto:{{ $item->email }}" target="_blank" icon="fas fa-at" />
                    <x-td field="fon" link="tel:{{ $item->fon }}" target="_blank" icon="fas fa-phone" />
                    <x-td field="postcode:md" />
                    <x-td field="city:md" />
                    <x-td field="street:md" />
                    <x-action routePrefix="admin.houseboatOwners" edit delete />
                    @endBindData
                </tr>
            @endforeach
        </x-table>
        {{ $data->links() }}
    </div>
@endsection
