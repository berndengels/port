@extends('layouts.main')

@section('main')
    <div>
        <x-nav-link href="{{ route('admin.customers.' . (isset($route) ? $route : 'index')) }}" icon="fas fa-backward" class="btn">zur Liste</x-nav-link>
        <div class="show-page">
            <div>
                <div>Bestätigt</div>
                <div>{!! $customer->icon('confirmed') !!}</div>
            </div>
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
                <div>Rollen</div>
                <div>
                    @if($customer->roles->count() > 0)
                        <ul>
                        @foreach($customer->roles as $role)
                            <li>{{ $role->name }}</li>
                        @endforeach
                        </ul>
                    @else
                        keine
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

