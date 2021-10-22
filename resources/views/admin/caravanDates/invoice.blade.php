@extends('layouts.main')

@section('main')
    <div class="m-5 content-center w-1/2">
        <x-nav-link :href="route('admin.caravanDates.index')" icon="fas fa-backward" class="btn">zurück</x-nav-link>
        <table class="table w-full">
            <tr>
                <th class="text-right">Kennzeichen</th>
                <td><span ondblclick="ondblclick()" class="carnumber cursor-pointer">{{ $caravanDate->caravan->carnumber }}</span></td>
            </tr>
            <tr>
                <th class="text-right">Wagenlänge</th>
                <td>{{ $caravanDate->caravan->carlength }} m</td>
            </tr>
            <tr>
                <th class="text-right">Personen</th>
                <td>{{ $caravanDate->persons }}</td>
            </tr>
            <tr>
                <th class="text-right">Strom-Anschluß</th>
                <td>{{ $caravanDate->electric ? 'JA' : 'Nein'}}</td>
            </tr>
            <tr>
                <th class="text-right">Von</th>
                <td>{{ $caravanDate->from->format('D d.m.Y') }}</td>
            </tr>
            <tr>
                <th class="text-right">Bis</th>
                <td>{{ $caravanDate->until->format('D d.m.Y') }}</td>
            </tr>
            <tr>
                <th class="text-right">Anzahl Übernachtungen</th>
                <td>{!! \Carbon\Carbon::create($caravanDate->from)->diff($caravanDate->until)->days !!}</td>
            </tr>
            <tr>
                <td colspan="2">
                    <div>
                        <table class="table w-full">
                            @foreach(json_decode($caravanDate->prices, true) as $date => $price)
                            <tr>
                                <th class="top-0">{{ \Carbon\Carbon::create($date)->format('D d.m.Y') }}</th>
                                <td>
                                    <table class="table w-full">
                                        @foreach($price as $key => $item)
                                        <tr>
                                            <th class="text-right">{{ $key }}</th>
                                            <td >{!! $item !!}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>

                </td>
            </tr>
        </table>
    </div>

@endsection

@section('inline-scripts')
    @parent
    <script>
        const url = "{{ route('admin.car.info', ['caravanId'=> $caravanDate->caravan->id]) }}"
	    var ondblclick = () => {
		    axios.get(route(url))
			    .then(resp => {
				    if(resp.data.data && !resp.data.error) {
					    let info = resp.data.data;
					    alert(info.location + " (" + info.state + ")")
				    }
			    })
			    .catch(e=>console.error(e));
	    }
    </script>
@endsection


