@php use Carbon\Carbon; @endphp
@props(['prices'])
<div class="row">
    <div class="col-auto">
        <h5>Preise</h5>
        <table class="table table-sm table-striped w-100">
            <tr>
                <th>{{ __('Service') }}</th>
                <th>{{ __('Preis') }}</th>
            </tr>
            @foreach($prices as $service => $item)
                @continue('days' === $service)
                @if('dailyPrices' === $service)
                    <tr>
                        <td colspan="2">Tagespreise</td>
                    </tr>
                    @foreach($item as $key => $val)
                        <tr>
                            <td>{{ (new Carbon($key))->format('d.m.Y') }}</td>
                            <td>{{ $val->price }} € ({{$val->saison}})</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>{{ __($service) }}</td>
                        <td>{{ $item }} @if('tax' === $service) % @else € @endif</td>
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
</div>
