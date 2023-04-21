@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3 p-0">
            <div class="w-100">
                <x-form class="row" method="get" name="frmFilter" action="{{ route('admin.infos.routes') }}">
                    <div class="col-sm-4 col-md-3">
                        <x-form-input
                                name="routeName"
                                placeholder="Routen Name"
                        />
                    </div>
                    <x-form-submit name="submit" class="btn btn-primary col-auto" inline>Suche</x-form-submit>
                    <button class="btn btn-outline-secondary reset col-auto ms-2">Reset</button>
                </x-form>
            </div>
            <div></div>
        </div>
        <table class="table table-striped table-sm mt-2">
            <tr>
                <th>Methode</th>
                <th>Route</th>
                <th>Uri</th>
                <th>Actions</th>
                <th>Middleware</th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td>{{ implode(', ',$item->methods()) }}</td>
                    <td>{{ isset($item->action['as']) ? $item->action['as'] : ''}}</td>
                    <td>{{ $item->uri }}</td>
                    <td>{{ $item->action['controller'] ?? null }}</td>
                    <td>{{ implode(', ', $item->middleware()) ?? null }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection

@push('inline-scripts')
<script>
$(document).ready(() => {
    $(".reset").click((e) => {
		e.preventDefault();
	    document.frmFilter.reset()
    });
});
</script>
@endpush
