@extends('layouts.main')

@section('main')
	<div class="row m-sm-2 mb-5 pb-5 align-self-center">
		<div class="m-auto col-sm-12 col-md-6 align-content-center">
			<h1 class="m-3 fs-3 dark-grey">{{ __('Kontakt Anfragen') }}</h1>
			<div>
				<x-form class="w-half mx-3 contact-form" method="post" action="{{ route('public.contacts.store') }}">
					<x-form-input name="name" label="Name" required placeholder="Ihr mit Anrede Name"/>
					<x-form-input name="email" type="email" label="Email" required placeholder="Ihre Email-Adresse"/>
					<x-form-input name="subject" label="Betreff" required placeholder="Kurz um was geht es"/>
					<x-form-textarea name="message" type="tel" label="Nachricht" required placeholder="Ihre Nachricht"/>
					<div class="mt-2 fs-6 blue"><strong>Captcha Text (zur Absicherung)</strong></div>
					<div class="form-group mt-1 clearfix">
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
						{{ __('Senden') }}
					</x-form-submit>
				</x-form>
			</div>
		</div>
	</div>
@endsection

@push('inline-scripts')
	<script>
		$(document).ready(() => {
			const reloadURL = "{{ route('public.reload.captcha') }}";
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
		});
	</script>
@endpush
