@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div>
                <x-form class="inline-form ml-5" method="get" id="frmFilter" name="frmFilter" action="{{ route('admin.infos.routes') }}">
                    <x-form-input
                        name="routeName"
                        class="inline-flex"
                        placeholder="Routen Name"
                        floating
                    />
                    <x-form-submit name="submit" inline class="btn btn-red">Suche</x-form-submit>
                    <button class="btn btn-reset inline" onclick="document.frmFilter.reset()">Reset</button>
                </x-form>
            </div>
            <div></div>
        </div>
        <table class="table w-full dt-left">
            <tr>
                <th>Methode</th>
                <th>Route</th>
                <th>Uri</th>
                <th>Middleware</th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td>{{ implode(', ',$item->methods()) }}</td>
                    <td>{{ isset($item->action['as']) ? $item->action['as'] : ''}}</td>
                    <td>{{ $item->uri }}</td>
                    <!--td>{{ $item->action['controller'] ?? null }}</td-->
                    <td>{{ implode(', ', $item->middleware()) ?? null }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
