@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3 p-0">
            <div class="float-start">
                <x-btn-create route="{{ route('admin.config.entities.create') }}" />
            </div>
            <div class="float-end"></div>
        </div>
        {{ $data->links() }}
        <x-table :items="$data" :fields="['Objekt','Komponenten']" hasActions isSmall>
            @foreach($data as $item)
                <tr>
                    @bindData($item)
                    <x-td field="model" translate />
                    <td class="pt-0">
                        @if($item->priceComponents->count() > 0)
                            <ul class="list-group list-group-sm mt-0">
                                @foreach ($item->priceComponents as $component)
                                    <li class="list-group-item list-group-item-primary fst-italic">{{ $component->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                    <x-action routePrefix="admin.config.entities" edit delete />
                    @endBindData
                </tr>
            @endforeach
        </x-table>
        {{ $data->links() }}
    </div>
@endsection
