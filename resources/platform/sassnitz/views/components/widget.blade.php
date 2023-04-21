<div class="flex-item-dashboard p-3 widget">
    <!--div class="title" style="@if($color)color:{{ $color }}@endif @if($bgColor)color:{{ $bgColor }}@endif">{{ $title }}</div>
    <div class="content mt-2" style="@if($color)color:{{ $color }};@endif @if($bgColor)background-color:{{ $bgColor }}@endif"-->
    <div class="title" >{{ $title }}</div>
    <div class="content mt-2">
        {!! $content !!}
    </div>
</div>
