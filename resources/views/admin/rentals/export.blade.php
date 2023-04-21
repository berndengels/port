<table>
    @if($data->count() > 0)
        <thead>
        <tr>
            <th>Objekt</th>
            <th>Von</th>
            <th>Bis</th>
            <th>Preis</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
            <tr>
                <td>{{ $item->rentable->name }}</td>
                <td>{{ $item->from->format('d.m.Y') }}</td>
                <td>{{ $item->until->format('d.m.Y') }}</td>
                <td>{{ $item->price }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" style="text-align:right">Summe Preis</td>
            <td><b style="color:#ff0000">{{ $priceTotal }}</b></td>
        </tr>
        </tbody>
    @else
        <thead>
        <tr>
            <th>Keine Daten vorhanden</th>
        </tr>
        </thead>
    @endif
</table>
