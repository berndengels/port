@php use Illuminate\Support\Carbon; @endphp
<div class="header {{ $class }}">
	<div class="clearfix">
		<div class="float-start">
        <span class="app-logo">
            <span>port</span><span>m</span>
        </span><span class="ms-1">{{ $settings->name }}</span>
		</div>
		<div class="float-end">
			<span>{{ $settings->location }} {{ Carbon::today()->format('d.m.Y') }}</span>
		</div>
	</div>
	<div class="mt-1">
		{{ $settings->postcode }} {{ $settings->location }}<br>
		{{ $settings->street }}<br>
		{{ $settings->fon }}<br>
		{{ $settings->email }}
	</div>
</div>
