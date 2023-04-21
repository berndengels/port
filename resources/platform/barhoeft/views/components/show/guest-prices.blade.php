@php use Carbon\Carbon; @endphp
@props(['prices'])
<div class="card">
    <div class="card-header"><trong>Preis Total {{ $prices->total }} €</trong></div>
    <div class="card-body p-3">
        @foreach($prices as $prop => $data)
            @if( is_string($prop) && (is_string($data) || is_int($data)))
                <div class="row">
                    <div class="col-9">{{ __($prop) }}</div>
                    <div class="col">{{ $data }} @if(preg_match('/price|total|netto/i', $prop)) € @elseif('tax' === $prop) % @endif</div>
                </div>
            @endif
            @if( 'dailyPrices' === $prop && is_array($data))
                <div class="row">
                    <div class="col"><strong>Tagespreise</strong></div>
                </div>
                @foreach($data as $date => $item)
                    <div class="row bg-dark-grey white">
                        <div class="col-4">{{ (new Carbon($date))->format('D d.m.Y') }}</div>
                        <div class="col-auto">{{ $item['price'] }} € ({{ $item['saison'] }})</div>
                    </div>
                @endforeach
            @endif
        @endforeach
    </div>
</div>
