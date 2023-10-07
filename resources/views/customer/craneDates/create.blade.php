@extends('layouts.main')
@php
	use Illuminate\Support\Str;
@endphp
@section('main')
	<div>
		<x-btn-back route="{{ route('customer.craneDates.index') }}"/>
		<x-form name="frm" method="post" action="{{ route('customer.craneDates.store') }}" class="w-half mt-3">
			<!--x-form-select class="calc" class="boat" id="cranable_type" name="cranable_type" label="Art"
						   :options="$cranableTypeOptions"/-->
			<x-form-select id="cranable_id" name="cranable_id" type="text" label="Boot"/>
			<x-form-input id="crane_date" name="crane_date" type="date" label="Datum"/>
			<x-form-input id="crane_time" name="crane_time" type="time" label="Uhrzeit"/>
			<div class="mt-2">
				<x-form-submit class="btn-sm btn-primary" icon="fas fa-save">
					Speichern
				</x-form-submit>
			</div>
		</x-form>
	</div>
@endsection

@push('inline-scripts')
	<script>
		$(document).ready(() => {
			const autofillParams = {
				cranable_id: document.frm.cranable_id,
			};

			$('#cranable_type').change(e => {
				let $el = $(e.target);
				if ($el.val() && "" !== $el.val()) {
					axios
						.post('admin/craneDates/cranable', {cranable_type: $el.val()})
						.then(resp => {
							if (resp.data) {
								$('#cranable_id').empty();
								$.each(resp.data, (id, val) => {
									let $option = $('<option>');
									$option.val(id).text(val).appendTo('#cranable_id');
								})
							}
						})
						.catch(e => console.error(e))
				}
			});
		});
	</script>
@endpush
