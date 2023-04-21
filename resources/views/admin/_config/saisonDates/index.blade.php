@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3 p-0">
            <div class="float-start">
                <x-btn-create route="{{ route('admin.config.saisonDates.create') }}" />
            </div>
            <div class="float-end"></div>
        </div>
        {{ $data->links() }}
        <x-table :items="$data" :fields="['Name','Betrifft','Von','Bis']" hasActions isSmall>
            @foreach($data as $item)
                <tr>
                    @bindData($item)
                    <x-td field="name" />
                    <x-td field="key" translate />
                    <x-td field="strFrom" />
                    <x-td field="strUntil" />
                    <x-action routePrefix="admin.config.saisonDates" edit delete />
                    @endBindData
                </tr>
            @endforeach
        </x-table>
        {{ $data->links() }}
    </div>
@endsection
