@extends('layouts.main')

@section('main')
	<div>
		<x-form class="inline-form ms-0 my-3" method="get" id="frmFilter" name="frmFilter"
				action="{{ route('admin.contacts.index') }}"
		>
			<x-filter name="name" :options="$nameOptions" :val="$name" inline/>
			<x-filter name="email" :options="$emailOptions" :val="$email" inline/>
			<x-filter name="year" :options="$yearOptions" :val="$year" inline/>
			@if($year)
				<x-filter name="month" :options="$monthOptions" :val="$month" inline/>
			@endif
			<x-btn-reset/>
		</x-form>
		{{ $data->appends($queryString)->links() }}
		<div class="container-fluid ps-0">
			<x-table :items="$data" :fields="['Name','Email','Betreff','Eingang']" hasActions isSmall>
				@foreach($data as $item)
					<tr>
						@bindData($item)
						<x-td field="name" link="{{ route('admin.contacts.show', $item) }}"/>
						<x-td field="email" email="email"/>
						<x-td field="subject"/>
						<x-td field="created_at" dateformat="d.m.Y H.i"/>
						<x-action routePrefix="admin.contacts" delete/>
						@endBindData
					</tr>
				@endforeach
			</x-table>
		</div>
		{{ $data->appends($queryString)->links() }}
	</div>
@endsection

@push('inline-scripts')
	<script>
		$(document).ready(() => {
			const frm = document.frmFilter,
				filter = (e) => {
					let el = e.target;
					if ('' === el.value && ['year', 'month'].indexOf(el.name) === -1) {
						return;
					}
					switch (el.name) {
						case 'name':
							frm.year.value = '';
							frm.email.value = '';
							if (frm.month) {
								frm.month.value = '';
							}
							break;
						case 'email':
							frm.year.value = '';
							frm.name.value = '';
							if (frm.month) {
								frm.month.value = '';
							}
							break;
						case 'year':
							if (frm.year.value === '' && frm.month) {
								frm.month.value = '';
							}
							frm.name.value = '';
							frm.email.value = '';
							break;
						case 'month':
							frm.name.value = '';
							frm.email.value = '';
							break
					}
					frm.submit()
				},
				reset = (e) => {
					e.preventDefault();
					document.frmFilter.name.value = '';
					document.frmFilter.email.value = '';
					document.frmFilter.year.value = '';
					if (undefined !== document.frmFilter.month) {
						document.frmFilter.month.value = '';
					}
					$(frm.month).hide();
					document.frmFilter.submit();
				};

			frm.querySelectorAll('.filter').forEach(item => {
				item.onchange = filter
			});
			frm.querySelector('.reset').onclick = reset;
		});
	</script>
@endpush
