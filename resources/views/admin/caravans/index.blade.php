@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3">
            <div>
                <x-nav-link
                        href="{{ route('admin.caravans.create') }}"
                        class="btn"
                        icon="far fa-plus-square"
                        text="Neueintrag"
                />
            </div>
            <div></div>
        </div>
        <x-form class="inline-form ml-5" method="get" id="frmFilter" name="frmFilter" action="{{ route('admin.caravans.index') }}">
            @csrf
            <x-form-select
                    name="caravan"
                    class="inline-block"
                    :options="$caravanOptions"
                    :default="$id"
                    placeholder="Filter nach Kennzeichen"
                    onchange="document.frmFilter.submit()"
                    floating
            />
            <button class="btn btn-reset inline">Reset</button>
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
                        <span class="carnumber cursor-pointer">{{ $item->carnumber }}</span>
                    </td>
                    <td class="hidden md:table-cell">{{ $item->carlength }} m</td>
                    <td class="hidden md:table-cell"><a href="mailto:{{ $item->email }}" target="_blank">{{ $item->email }}</a><br v-else></td>
                    <td>
                        <x-nav-link href="{{ route('admin.caravans.edit', $item) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">
                            <span class="hidden md:visible">Edit</span>
                        </x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('admin.caravans.destroy', ['caravan' => $item]) }}"
                                class="m-0 p-0">
                            @method('delete')
                            <x-form-submit icon="fas fa-trash-alt" inline class="mt-0 btn-red delSoft">
                                <span class="hidden md:visible">
                                    Löschen
                                </span>
                            </x-form-submit>
                        </x-form>
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $data->links() }}
    </div>
    <x-tooltip id="tooltip" />
@endsection

@push('inline-scripts')
<script>
    $(".btn-reset").click( e => {
		e.preventDefault();
		document.frmFilter.caravan.value = ''
	    document.frmFilter.submit();
    });
    const routePrefix = "{{ route('admin.car.info') }}"
    Car.info(routePrefix, '.carnumber', '#tooltip')
</script>
@endpush
