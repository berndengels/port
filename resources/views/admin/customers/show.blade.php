@extends('layouts.main')

@section('main')
    <div class="m-5 content-center w-1/2">
        <x-nav-link :href="route('admin.customers.index')" icon="fas fa-backward" class="btn">zur Liste</x-nav-link>
        <div class="show-page">
            <div>
                <div>Name</div>
                <div>{{ $customer->name }}</div>
            </div>
            <div>
                <div>Email</div>
                <div><a href="mailto:{{ $customer->email }}" target="_blank">{{ $customer->email }}</a></div>
            </div>
            <div>
                <div>Fon</div>
                <div>
                    @if($customer->fon)
                        <a href="tel:{{ $customer->fonLink }}" target="_blank">
                            <i class="fas fa-phone"></i>
                            {{ $customer->fon }}
                        </a>
                    @endif
                </div>
            </div>
            <div>
                <div>Straße</div>
                <div>{{ $customer->street }}</div>
            </div>
            <div>
                <div>PLZ</div>
                <div>{{ $customer->postcode }}</div>
            </div>
            <div>
                <div>Ort</div>
                <div>{{ $customer->city }}</div>
            </div>
            <div>
                <div>Bestätigt</div>
                <div>{{ $customer->confirmed ? 'JA' : 'NEIN' }}</div>
            </div>
        </div>
@endsection

