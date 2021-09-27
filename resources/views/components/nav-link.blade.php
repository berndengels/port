<a href="{{ $href }}" class="{{ $class }}" >
    @if($icon)
        <i class="{{ $icon }}"></i>
    @endif
    @if($text)
        {{ $text }}
    @else
        {!! trim($slot) !!}
    @endif
</a>
