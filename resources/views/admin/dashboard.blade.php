@extends('layouts.default')

@section('main')
<div class="main-header">Dashboard</div>
<div class="main-cards">
    <div class="card">
        <div>
            <h5 v-if="0 === countCurrentCaravans">zur Zeit sind keine Wohnmobile hier</h5>
            <h5 v-else-if="1 === countCurrentCaravans">zur Zeit ist 1 Wohnmobil hier</h5>
            <h5 v-else>zur Zeit sind  Wohnmobile hier</h5>
            <div v-if="countCurrentCaravans > 0" class="flex-container">
                <div class="flex flex-wrap flex-shrink-0 carnumber">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
