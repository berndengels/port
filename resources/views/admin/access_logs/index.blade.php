@extends('layouts.main')

@section('main')
    <div>
        @if($data->count())
        {{ $data->links() }}
        <x-table :items="$data" :fields="['IP','Land:md','Ort','Bundesland:md','Zugriff']" isSmall>
            @foreach($data as $item)
                <tr>
                    @bindData($item)
                    <x-td field="ip" :link="route('admin.accessLogs.show', $item)" />
                    <x-td field="country:md" translate />
                    <x-td field="city" />
                    <x-td field="state:md" />
                    <x-td field="created_at" dateformat="d.m.Y H:i" />
                    @endBindData
                </tr>
            @endforeach
        </x-table>
        {{ $data->links() }}
        @else
            <h3>Keine Daten vorhanden</h3>
        @endif
    </div>
@endsection
