@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3 p-0">
            <div class="float-start">
                <x-btn-create route="{{ route('admin.boats.create') }}" />
            </div>
            <div class="float-end"></div>
        </div>
        {{ $data->links() }}
        <x-table :items="$data"
                 :fields="['Name','Typ','Eigner:md','Fon','Liegeplatz']"
                 :sortable="['name'=>'Name','type'=>'Typ','customer.name'=>'Eigner']"
                 hasActions isSmall>
            @foreach($data as $item)
                <tr>
                    @bindData($item)
                    <x-td field="name" :link="route('admin.boats.show', $item)" />
                    <x-td field="type" translate />
                    <x-td field="customer.name:md" email="customer.email" />
                    <x-td field="customer.fon" fon />
                    <x-td field="berth.dock.name" :append="['berth.number']" />
                    <x-action routePrefix="admin.boats" edit delete />
                    @endBindData
                </tr>
            @endforeach
        </x-table>
        {{ $data->links() }}
    </div>
@endsection
