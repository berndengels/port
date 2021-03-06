@extends('layouts.main')

@section('main')
    <div class="w-full">
        <h1 class="sm:mt-5 m-3 text-4xl">{{ __('Registrierung für Dauerlieger') }}</h1>
        <div class="flex w-full justify-center mb-5">
            <x-form class="w-full mx-3 md:w-1/2 register-form" method="post" action="{{ route('register') }}">
                <x-form-input type="hidden" name="customer_type" default="permanent"/>
                <x-form-input name="name" label="Name" required placeholder="Name"/>
                <x-form-input name="email" type="email" label="Email" required placeholder="Email"/>
                <x-form-input name="password" type="password" label="Passwort" required/>
                <x-form-input name="password_confirmation" type="password" label="Passwort wiederholen" required/>
                <x-form-input name="fon" type="tel" label="Telefon" required placeholder="Telefon"/>
                <x-form-input name="street" label="Straße u.Hausnummer" required placeholder="Straße u.Hausnummer"/>
                <x-form-input name="postcode" label="PLZ" required placeholder="PLZ"/>
                <x-form-input name="city" label="Ort" required placeholder="Ort"/>

                <div class="mt-3 p-3 bg-blue-800">
                    <span class="text-2xl text-white">Bootsdaten</span>
                </div>

                <x-form-select id="boat_type" name="boat_type" label="Boots Typ" :options="$boatTypes" required/>
                <x-form-group class="sail hidden">
                    <x-form-input name="mast_length" type="number" step="1" label="Mastlänge in Meter"
                                  placeholder="Mastlänge"/>
                    <x-form-input name="mast_weight" type="number" step="1" label="Mastgewicht in Kg"
                                  placeholder="Mastgewicht in Kilogramm"/>
                    <x-form-input name="length_keel" type="number" step="0.1" label="Kiellänge in Meter"
                                  placeholder="Kiellänge"/>
                </x-form-group>
                <x-form-input name="boat_name" label="Boots Name" required placeholder="Boots Name"/>
                <x-form-input name="length" type="number" step="0.1" label="Boots Länge in Meter"
                              placeholder="Boots Länge" required/>
                <x-form-input name="width" type="number" step="0.1" label="Boots Breite in Meter"
                              placeholder="Boots Breite"/>
                <x-form-input name="weight" type="number" step="100" label="Boots Gewicht in Kg"
                              placeholder="Gewicht in Kilogramm"/>
                <x-form-input name="board_height" type="number" step="0.1" label="Bordhöhe in Meter"
                              placeholder="Höhe Bord über Wasserlinie in Meter"/>
                <x-form-input name="draft" type="number" step="0.1" label="Tiefgang in Meter" placeholder="Tiefgang"/>
                <x-form-input name="length_waterline" type="number" step="0.1" step="0.1"
                              label="Länge Wasserlinie in Meter" placeholder="Länge Wasserlinie"/>

                @if(! app()->environment('testing') )
                    <div class="form-group mt-4 mb-4">
                        <span class="block text-xl text-blue-900 mb-2">Captcha Text (zur Absicherung)</span>
                        <div class="captcha">
                        <span>
                            {!! captcha_img('flat') !!}
                        <button type="button" class="btn btn-danger inline-block" class="reload" id="reload">
                            &#x21bb;
                        </button>
                        </span>
                        </div>
                    </div>
                    <x-form-input id="captcha" name="captcha" label="Hier den darüber angezeigten Text eintragen"
                                  placeholder="Hier Captcha Text eintragen"/>
                @endif

                <x-form-submit class="btn btn-save h-10 mt-3 w-full md:w-1/2" icon="fas fa-sign-in-alt">
                    {{ __('Register') }}
                </x-form-submit>
            </x-form>
        </div>
    </div>
@endsection

@push('inline-scripts')
    <script>
		$('#boat_type').change(e => {
			switch (e.target.value) {
				case 'sail':
					$('.sail').fadeIn();
					break;
				case 'motor':
					$('.sail').fadeOut();
					break;
			}
		});
        @if(! app()->environment('testing'))
		const reloadURL = "{{ route('public.reload.captcha') }}";
		$('#reload').click(function () {
			$.ajax({
				type: 'GET',
				url: reloadURL,
				success: function (data) {
					$(".captcha span").html(data.captcha);
				}
			});
		});
        @endif
    </script>
@endpush
