@extends('layouts.main')

@section('main')
    <div>
        <div class="index-header mt-3 p-0">
            <div class="float-start">
                <x-btn-create route="{{ route('admin.boatDates.create', ['modus' => $saison ?? null]) }}" />
            </div>
        @if($data->count() > 0 && $from || $until)
            <div class="float-end">
                <x-frm-excel
                    :action="route('admin.boatDates.sendExcel')"
                    routeDownload="{{ route('admin.boat.price.excel', compact('from','until')) }}"
                    :from="$from"
                    :until="$until"
                />
            </div>
        @endif
        </div>

        @if($data->count() > 0)
        <x-form class="inline-form ms-0 my-3" method="get" id="frmFilter" name="frmFilter"
                action="{{ route('admin.boatDates.index') }}"
        >
            <x-filter name="boat" :options="$boatOptions" :val="$boat" inline />
            <x-filter name="saison" :options="$saisonOptions" :val="$saison" inline />
            <x-form-input :default="$from ? $from->format('Y-m-d') : null" name="from" type="date" :min="$firstDate->format('Y-m-d')" :max="$lastDate->format('Y-m-d')" inline label="von" placeholder="Von" />
            <x-form-input :default="$until ? $until->format('Y-m-d') : null" name="until" type="date" :min="$firstDate->format('Y-m-d')" :max="$lastDate->format('Y-m-d')" inline label="bis" placeholder="Bis" />
            <x-btn-reset />
        </x-form>
        {{ $data->appends($queryString)->links() }}
        <div class="container-fluid ps-0">
            <div class="row mt-3">
                <div class="col-sm-11 col-lg-9">
                    <x-table :items="$data"
                             :fields="['Boot','Saison','Von','Bis','Eigner:md','Fon','Preis in €:md','Bezahlt']"
                             :sortable="['boat.name'=>'Boot','from'=>'Von','until'=>'Bis']"
                             hasActions isSmall>
                        @foreach($data as $item)
                            <tr>
                                @bindData($item)
                                <x-td field="boat.name" :link="route('admin.boatDates.show', $item)" />
                                <x-td field="modus" translate />
                                <x-td field="from" />
                                <x-td field="until" />
                                <x-td field="boat.customer.name:md" email="boat.customer.email" />
                                <x-td field="boat.customer.fon" fon />
                                <x-td field="price:md" />
                                <x-td field="is_paid" />
                                <x-action routePrefix="admin.boatDates" edit delete />
                                @endBindData
                            </tr>
                        @endforeach
                    </x-table>
                </div>
                <div class="col-sm-11 col-lg-2 mt-3">
                    <x-sum-price :brutto="$priceTotal" />
                </div>
            </div>
        </div>
        {{ $data->appends($queryString)->links() }}
        @endif
    </div>
@endsection

@push('inline-scripts')
<script>
    $(document).ready(() => {
        Edit.toggle("/admin/boatDates/toggle","is_paid");
        const frm = document.frmFilter,
            filter = (e) => {
                let el = e.target;
                if('' === el.value || !el.value) {
                    return;
                }
                switch (el.name) {
                    case 'boat':
                        frm.from.value = '';
	                    frm.until.value = '';
                        break;
                    case 'from':
                    case 'saison':
                    case 'until':
                        frm.boat.value = '';
                        break
                }
                frm.submit()
            },
            reset = (e) => {
                e.preventDefault();
	            document.frmFilter.reset();
	            document.frmFilter.boat.value = '';
	            document.frmFilter.saison.value = '';
	            document.frmFilter.from.value = '';
                document.frmFilter.until.value = '';
	            document.frmFilter.submit()
            };

        frm.querySelectorAll('.filter').forEach(item => item.onchange = filter);
        frm.querySelector('.reset').onclick = reset
    });
</script>
@endpush
