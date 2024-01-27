@php use Illuminate\Support\Str @endphp
<div class="navbar navbar-expand mt-0 p-0">
	<ul class="nav">
		@foreach($items as $name => $item)
			@php
				$selector = strtolower(Str::snake($name))
			@endphp
			<li class="nav-item parent">
				@isset($item['route'])
					<a class="nav-link"
						 data-route="{{ isset($item['segment']) ? $item['segment'] : null }}"
						 href="{{ route($item['route']) }}"
						 title="{{ $item['title'] }}">
					@if(isset($item['icon']))<i class="icn {{ $item['icon'] }}"></i>@endif
					{{ $item['text'] }}</a>
				@else

				@endisset

				@if(isset($item['items']) && is_array($item['items']) && count($item['items']) > 0 )
					<div class="btn-toggle align-items-center rounded parent"
						 data-bs-toggle="collapse"
						 data-bs-target="#{{ $selector }}-collapse"
						 aria-expanded="true">
						@if(isset($item['icon']))<i class="icn {{ $item['icon'] }}"></i>@endif
						{{ __($name) }}
					</div>
					<div class="collapse" id="{{ $selector }}-collapse">
						<ul class="btn-toggle-nav list-unstyled fw-normal small">
							@foreach($item['items'] as $k => $v)
								@if($user->can($item['permissions']))
								<li class="nav-item">
									<a class="nav-link"
									   data-route="{{ isset($item['segment']) ? $item['segment'] : null }}"
									   href="{{ route($v['route']) }}"
									   title="{{ $v['title'] }}">
										@if(isset($v['icon']))<i class="icn {{ $v['icon'] }}"></i>@endif
										{{ $v['text'] }} ()
									</a>
								</li>
								@endif
							@endforeach
						</ul>
					</div>
				@endif
			</li>
		@endforeach
	</ul>
</div>
@push('inline-scripts')
	<script>
		Navbar.init({!! json_encode(request()->segments()) !!});
	</script>
@endpush
