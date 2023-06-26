@extends('layouts.main')

@section('main')
	<div class="row m-sm-2 mb-5 pb-5 align-self-center">
		<div class="m-auto col-sm-12 col-md-6 align-content-center">
			<h1 class="m-3 fs-3 dark-grey">{{ __('Registrierung für Kunden') }}</h1>
			<div>
				<x-form class="w-half mx-3 register-form" method="post" action="{{ route('register') }}">
					<x-form-select name="type" :options="$customerTypes" label="Kunden-Typ"/>
					<x-form-input name="name" label="Name" required placeholder="Name"/>
					<x-form-input name="email" type="email" label="Email" required placeholder="Email"/>
					<x-form-input name="password" type="password" label="Passwort" placeholder="Passwort" required/>
					<x-form-input name="password_confirmation" type="password" label="Passwort wiederholen" required/>
					<div class="form-group mt-2 clearfix captcha-wrapper d-none">
						<div class="captcha float-start">
							<span class="d-inline-block">{!! captcha_img('flat') !!}</span>
							<a href="#" role="button" class="btn btn-danger" class="reload" id="reload">
								&#x21bb;
							</a>
						</div>
						<div class="float-end">
							<x-form-input floating class="" id="captcha" name="captcha"
										  placeholder="Hier den Captcha Text eintragen"/>
						</div>
					</div>
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
		const reloadURL = "{{ route('public.reload.captcha') }}";
		$.ajax({
			type: 'GET',
			url: reloadURL,
			success: function (data) {
				$(".captcha span").html(data.captcha);
				$(".captcha-wrapper").removeClass("d-none");
			}
		});
		$('#reload').click(e => {
			e.preventDefault();
			$.ajax({
				type: 'GET',
				url: reloadURL,
				success: function (data) {
					$(".captcha span").html(data.captcha);
				}
			});
		});
	</script>
@endpush
