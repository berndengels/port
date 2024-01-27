@php use Illuminate\Support\Str; @endphp
<div class="navbar navbar-expand">
    <ul class="nav">
        @foreach($items as $name => $item)
            {{--
            @isset($item['permissions'])
                @cannot($item['permissions'])
                    @continue
                @endcannot
            @endisset
            --}}
            @php
                $segment = isset($item['segment']) ? $item['segment'] : null;
				$id = strtolower(Str::snake($name));
            @endphp
            <li class="nav-item parent">
                @isset($item['route'])
                    <a href="{{ route($item['route']) }}"
                        data-route="{{ $segment }}"
                        class="nav-link">
                        @isset($item['icon'])<i class="icn {{ $item['icon'] }}"></i>@endisset {{ __($name) }}</a>
                @else
                    <div class="btn-toggle align-items-center rounded"
                         data-bs-toggle="collapse"
                         data-bs-target="#{{ $id }}-collapse"
                         aria-expanded="true">
                         @isset($item['icon'])<i class="icn {{ $item['icon'] }}"></i>@endisset {{ __($name) }}</div>
                    @if(isset($item['items']) && is_array($item['items']) && count($item['items']) > 0)
                        <div class="collapse" id="{{ $id }}-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                @foreach($item['items'] as $n => $v)
                                    <li class="nav-item">
                                        <a href="{{ route($v['route']) }}"
                                            data-route="{{ $v['segment'] }}" class="nav-link ms-3" title="{{ $v['title'] }}">
                                            @isset($v['icon'])<i class="icn {{ $v['icon'] }}"></i>@endisset {{ $v['text'] }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endisset
            </li>
        @endforeach
    </ul>
</div>

@push('inline-scripts')
    <script>
        Navbar.init('{{ request()->segment(2) }}');
    </script>
@endpush
