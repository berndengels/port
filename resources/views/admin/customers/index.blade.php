@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3 p-0">
            <div class="ms-0">
                <x-btn-create route="{{ route('admin.customers.create', ['type' => $type]) }}" />
            </div>
            <div></div>
        </div>
        {{ $data->links() }}
        <x-table :items="$data" :fields="['Name','Email:md','Fon','Bestätigt']" hasActions isSmall>
            @foreach($data as $item)
                <tr>
                    @bindData($item)
                    <x-td field="name" link="{{ route('admin.houseboatOwners.show', $item) }}" />
                    <x-td field="email:md" email />
                    <x-td field="fon" fon />
                    <x-td field="confirmed" />
                    <x-action routePrefix="admin.customers" edit delete />
                    @endBindData
                </tr>
            @endforeach
        </x-table>
        {{ $data->links() }}
    </div>
@endsection
