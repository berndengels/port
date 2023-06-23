@extends('layouts.main')

@section('main')
	<div>
		<div class="index-header mt-3 p-0">
			<div class="ms-0">
				<x-nav-link
						href="{{ route('admin.pages.create') }}"
						class="btn btn-secondary"
						icon="far fa-plus-square"
						text="Neueintrag"
				/>
			</div>
			<div></div>
		</div>
		{{ $data->links() }}
		<x-table :items="$data" :fields="['Titel:sm','Slug:md']" hasActions isSmall>
			@foreach($data as $item)
				<tr>
					@bindData($item)
					<x-td field="title:sm"/>
					<x-td field="slug:md"/>
					<x-action routePrefix="admin.pages" edit delete/>
					@endBindData
				</tr>
			@endforeach
		</x-table>
		{{ $data->links() }}
	</div>
@endsection
