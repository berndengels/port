@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3 p-0">
            <div class="float-start"></div>
            <div class="float-end"></div>
        </div>
        {{ $data->links() }}
        <x-table :items="$data" :fields="['Kunde:md','Boot','Beschreibung:md','Erledigt','Fertigstellung','Bezahlt']" hasActions isSmall>
            @foreach($data as $item)
                <tr>
                    @bindData($item)
                    <x-td field="boat.customer.name:md" />
                    <x-td field="boat.name" link="{{ route('admin.serviceRequests.show', $item) }}" icon="fas fa-eye" />
                    <x-td field="description:md" short="30" />
                    <x-td field="done" />
                    <x-td field="done_until" />
                    <x-td field="is_paid" />
                    <x-action routePrefix="admin.serviceRequests" show delete />
                    @endBindData
                </tr>
            @endforeach
        </x-table>
        {{ $data->links() }}
    </div>
@endsection

@push('inline-scripts')
<script>
$(document).ready(() => {
	const route = "/admin/serviceRequests/toggle";
	Edit.toggle(route, "done", ".done");
	Edit.toggle(route, "is_paid", ".is_paid")
});
</script>
@endpush
