<a href="{{ $href }}" class="{{ $class }}" >
    @if($icon)
        <i class="{{ $icon }}"></i>
    @endif
    <span>
        @if($text)
            {{ $text }}
        @else
            {!! trim($slot) !!}
        @endif
    </span>
</a>
