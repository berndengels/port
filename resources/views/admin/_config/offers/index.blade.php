@extends('layouts.main')

@section('main')
    <div class="mt-5">
        <h1 class="m-5">Angebote freischalten</h1>
        {{ $data->links() }}
        <table class="table w-full mt-5">
            <tr>
                <th>ID</th>
                <th>Angebot</th>
                <th>Aktiv</th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td rel="{{ $item->id }}">{!! $item->icon('enabled') !!}</td>
                </tr>
            @endforeach
        </table>

        {{ $data->links() }}
    </div>
@endsection

@push('inline-scripts')
<script>
	Edit.toggle("/admin/offers/toggle","enabled")
</script>
@endpush
