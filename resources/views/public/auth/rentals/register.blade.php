@extends('layouts.main')

@section('main')
	<div class="row m-sm-2 m-md-5 align-self-center">
		<div class="m-auto col-sm-12 col-md-6 align-content-center">
			<h1 class="m-3 fs-3 dark-grey">{{ __('Registrierung für Dauerlieger') }}</h1>
			<div>
				<x-form class="w-half mx-3 register-form" method="post" action="{{ route('register') }}">
					<x-form-input type="hidden" name="type" default="permanent"/>
					<x-form-input name="name" label="Name" required placeholder="Name"/>
					<x-form-input name="email" type="email" label="Email" required placeholder="Email"/>
					<x-form-input name="password" type="password" label="Passwort" placeholder="Passwort" required/>
					<x-form-input name="password_confirmation" type="password" label="Passwort wiederholen" required/>
					<x-form-input name="fon" type="tel" label="Telefon" required placeholder="Telefon"/>
					<x-form-input name="street" label="Straße u. Hausnummer" required
								  placeholder="Straße u. Hausnummer"/>
					<x-form-input name="postcode" label="PLZ" required placeholder="PLZ"/>
					<x-form-input name="city" label="Ort" required placeholder="Ort"/>

					<div class="mt-3 p-3 bg-blue">
						<span class="fs-3 white">Bootsdaten</span>
					</div>

					<x-form-select id="type" name="type" label="Boots Typ" :options="$boatTypes" required/>
					<x-form-group class="sail hidden">
						<x-form-input name="mast_length" type="number" step="1" label="Mastlänge in Meter"
									  placeholder="Mastlänge"/>
						<x-form-input name="mast_weight" type="number" step="1" label="Mastgewicht in Kg"
									  placeholder="Mastgewicht in Kilogramm"/>
						<x-form-input name="length_keel" type="number" step="0.1" label="Kiellänge in Meter"
									  placeholder="Kiellänge"/>
					</x-form-group>
					<x-form-input name="name" label="Boots Name" required placeholder="Boots Name"/>
					<x-form-input name="length" type="number" step="0.1" label="Boots Länge in Meter"
								  placeholder="Boots Länge" required/>
					<x-form-input name="width" type="number" step="0.1" label="Boots Breite in Meter"
								  placeholder="Boots Breite"/>
					<x-form-input name="weight" type="number" step="100" label="Boots Gewicht in Kg"
								  placeholder="Gewicht in Kilogramm"/>
					<x-form-input name="board_height" type="number" step="0.1" label="Bordhöhe in Meter"
								  placeholder="Höhe Bord über Wasserlinie in Meter"/>
					<x-form-input name="draft" type="number" step="0.1" label="Tiefgang in Meter"
								  placeholder="Tiefgang"/>
					<x-form-input name="length_waterline" type="number" step="0.1" step="0.1"
								  label="Länge Wasserlinie in Meter" placeholder="Länge Wasserlinie"/>

					<div class="form-group mt-4 mb-4">
						<span class="d-block fs-3 blue mb-2">Captcha Text (zur Absicherung)</span>
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

					<x-form-submit class="btn btn-secondary mt-3" icon="fas fa-sign-in-alt">
						{{ __('Register') }}
					</x-form-submit>
				</x-form>
			</div>
		</div>
	</div>
@endsection

@push('inline-scripts')
	<script>
		$('#type').change(e => {
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
