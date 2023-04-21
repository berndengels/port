@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3 p-0">
            <div class="float-start">
                <x-btn-create route="{{ route('admin.config.dailyPrices.create') }}" />
            </div>
            <div class="float-end"></div>
        </div>
        {{ $data->links() }}
        <x-table :items="$data" :fields="['Objekt','Saison','Preis-Typ','Von','Bis','Preis in €']" hasActions isSmall>
            @foreach($data as $item)
                <tr>
                    @bindData($item)
                    <x-td field="model" translate />
                    <x-td field="saison.name" />
                    <x-td field="priceType.name" />
                    @if($item->from_unit)
                        <x-td field="from_unit" :append="['priceType.unit']" />
                    @else
                        <td>egal</td>
                    @endif
                    @if($item->until_unit)
                        <x-td field="until_unit" :append="['priceType.unit']" />
                    @else
                        <td>egal</td>
                    @endif
                    <x-td field="price" />
                    <x-action routePrefix="admin.config.dailyPrices" edit delete />
                    @endBindData
                </tr>
            @endforeach
        </x-table>
        {{ $data->links() }}
    </div>
@endsection
