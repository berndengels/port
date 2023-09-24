@if($floating)
	<div class="form-floating">
@endif
		<select name="{{ $name }}" id="{{ $name }}"
				{!! $attributes->merge([
						'class' => 'filter form-select form-select-sm h-auto p-2'
							. (!$floating ? ' mt-1' : '')
							. ($floating ? ' d-inline-block d-inline-flex mt-0' : '')
							. ($class ? ' '.$class : ''),
				]) !!}
		>
			@forelse($options as $key => $option)
				<option value="{{ $key }}" @if($isSelected($key)) selected="selected" @endif>
					{{ $option }}
				</option>
			@empty
				{!! $slot !!}
			@endforelse
		</select>
@if($floating)
	</div>
@endif
