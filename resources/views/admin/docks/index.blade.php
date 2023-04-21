@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3 p-0">
            <div class="float-start">
                <x-btn-create route="{{ route('admin.docks.create') }}" />
            </div>
            <div class="float-end"></div>
        </div>
        <p class="m-0 p-0 mt-2">Anzahl Liegeplätze {{ $countBerths }}</p>
        {{ $data->links() }}
        <x-table :items="$data" :fields="['Name','Liegeplätze']" hasActions isSmall>
            @foreach($data as $item)
                <tr>
                    @bindData($item)
                    <x-td field="name" />
                    <td>{{ ($item->berths) ? $item->berths->count() : 0 }}</td>
                    <x-action routePrefix="admin.docks" edit delete />
                    @endBindData
                </tr>
            @endforeach
        </x-table>
        {{ $data->links() }}
    </div>
@endsection
