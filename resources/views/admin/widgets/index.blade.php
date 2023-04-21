@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3 p-0">
            <div class="ms-0">
                <x-btn-create route="{{ route('admin.widgets.create') }}" />
            </div>
            <div></div>
        </div>
        {{ $data->links() }}
        <x-table :items="$data" :fields="['Position','Titel','Slug:md']" hasActions isSmall>
            @foreach($data as $item)
                <tr>
                    @bindData($item)
                    <x-td field="position" />
                    <x-td field="title" />
                    <x-td field="slug:md" />
                    <x-action routePrefix="admin.widgets" edit delete />
                    @endBindData
                </tr>
            @endforeach
        </x-table>
        {{ $data->links() }}
    </div>
@endsection
