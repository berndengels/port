@extends('layouts.admin')

@section('main')
    <div>
        <x-form method="post" name="frmFilter" action="{{ route('caravans.index') }}">
            @csrf
            <x-form-select name="caravan" label="Filter" :options="$caravanOptions" @change="document.frmFilter.submit()" />
        </x-form>
        {{ $data->links() }}
        <table class="table w-full">
            <tr>
                <th>Kennzeichen</th>
                <th class="hidden md:table-cell">Länge</th>
                <th class="hidden md:table-cell">Email</th>
                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td class="has-tooltip">
                        <span @dblclick="" class="carnumber cursor-pointer">{{ $item->carnumber }}</span>
                    </td>
                    <td class="hidden md:table-cell">{{ $item->carlength }} m</td>
                    <td class="hidden md:table-cell"><a href="mailto:{{ $item->email }}" target="_blank">{{ $item->email }}</a><br v-else></td>
                    <td>
                        <a href="{{ route('caravans.edit', $item) }}" icon="fas fa-edit" ctrClass="btn" title="Bearbeiten">
                            Edit
                        </a>
                    </td>
                    <td>
                        <a role="button" href="{{ route('caravans.destroy', $item) }}" icon="fas fa-trash-alt" title="Löschen">
                            Löschen
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
        {{ $data->links() }}
    </div>
@endsection

