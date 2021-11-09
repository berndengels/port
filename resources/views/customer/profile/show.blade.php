@extends('layouts.main')

@section('main')
    <div class="m-5 content-center w-1/2">
        <div class="show-page">
            <div>
                <div>Name</div>
                <div>{{ $profile->name }}</div>
            </div>
            <div>
                <div>Email</div>
                <div><a href="mailto:{{ $profile->email }}" target="_blank">{{ $profile->email }}</a></div>
            </div>
            <div>
                <div>Fon</div>
                <div>
                    @if($profile->fon)
                        <a href="tel:{{ $profile->fonLink }}" target="_blank">
                            <i class="fas fa-phone"></i>
                            {{ $profile->fon }}
                        </a>
                    @endif
                </div>
            </div>
            <div>
                <div>Straße</div>
                <div>{{ $profile->street }}</div>
            </div>
            <div>
                <div>PLZ</div>
                <div>{{ $profile->postcode }}</div>
            </div>
            <div>
                <div>Ort</div>
                <div>{{ $profile->city }}</div>
            </div>
            <div>
                <div></div>
            </div>
        </div>
        <div>
            <x-nav-link :href="route('customer.profile.edit', $profile)" icon="fas fa-edit" class="btn float-right">Daten ändern</x-nav-link>
        </div>
    </div>
@endsection

