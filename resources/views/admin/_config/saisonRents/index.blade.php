@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div class="ms-0">
                <x-btn-create route="{{ route('admin.config.saisonRents.create') }}" />
            </div>
            <div></div>
        </div>
        {{ $data->links() }}
        <x-table :items="$data" :fields="['Key','Name']" hasActions isSmall>
            @foreach($data as $item)
                <tr>
                    @bindData($item)
                    <x-td field="key" />
                    <x-td field="name" />
                    <x-action routePrefix="admin.config.saisonRents" edit delete />
                    @endBindData
                </tr>
            @endforeach
        </x-table>
        {{ $data->links() }}
    </div>
@endsection
