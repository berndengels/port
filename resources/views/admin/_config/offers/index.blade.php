@extends('layouts.main')

@section('main')
	<div>
		<h3 class="grey">Angebote freischalten</h3>
		{{ $data->links() }}
		<x-table :items="$data" :fields="['Angebot','Aktiv']" isSmall>
			@foreach($data as $item)
				<tr>
					@bindData($item)
					<x-td field="name"/>
					<x-td field="enabled"/>
					@endBindData
				</tr>
			@endforeach
		</x-table>
		{{ $data->links() }}
	</div>
@endsection

@push('inline-scripts')
	<script>
		Edit.toggle("/admin/offers/toggle", "enabled", true)
	</script>
@endpush
