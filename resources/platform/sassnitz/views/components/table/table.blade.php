@if($items->count())
    <table class="port-table table @if($striped)table-striped @endif @if($isSmall)table-sm w-auto @endif{{ $class }}">
        <thead>
            <tr>
                @foreach($captions as $field)
                    <th scope="col" @if($styles[$field]) class="{{ $styles[$field] }}"@endif >{{ $field }}</th>
                @endforeach
                @if($hasActions)
                    <th scope="col">Aktion</th>
                @endif
            </tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
@else
    <div class="mt-3">
        <h5>Keine Daten vorhanden</h5>
    </div>
@endif
