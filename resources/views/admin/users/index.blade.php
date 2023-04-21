@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3 p-0">
            <div class="ms-0">
                <x-btn-create route="{{ route('admin.users.create') }}" />
            </div>
            <div></div>
        </div>
        {{ $data->links() }}
        <x-table :items="$data" :fields="['Name','Email','Roles:md']" hasActions isSmall>
            @foreach($data as $item)
                <tr>
                    @bindData($item)
                    <x-td field="name" />
                    <x-td field="email" link="mailto:{{ $item->email }}" target="_blank" icon="fas fa-at" />
                    <x-td field="strRoles:md" />
                    <x-action routePrefix="admin.users" edit delete />
                    @endBindData
                </tr>
            @endforeach
        </x-table>
        {{ $data->links() }}
    </div>
@endsection
