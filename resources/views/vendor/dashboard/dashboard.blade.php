@extends('layouts.main')

@section('main')
	<div
			x-data="theme('{{ $theme }}', '{{ $initialMode }}')"
			x-init="init"
			:class="mode === 'dark' ? 'dark-mode' : ''"
	>
		<div class="fixed inset-0 w-screen h-screen grid gap-2 p-2 bg-canvas text-default dashboard">
			<livewire:dashboard-update-mode/>
			{{ $slot }}
		</div>
	</div>
	<livewire:scripts/>
	@stack('scripts')
	<script>
		const theme = (theme, initialMode) => ({
			theme,
			mode: initialMode,
			init() {
				if (this.theme === 'device') {
					this.detectDeviceColorScheme();
					return;
				}
				if (this.theme === 'auto') {
					this.listenForUpdateModeEvent();

				}
			},
			detectDeviceColorScheme() {
				const mediaQuery = matchMedia("(prefers-color-scheme: dark)");

				this.mode = mediaQuery.matches ? 'dark' : 'light';

				mediaQuery.addListener((event) => {
					this.mode = mediaQuery.matches ? 'dark' : 'light';
				});
			},

			listenForUpdateModeEvent() {
				window.livewire.on('updateMode', newMode => {
					if (newMode !== this.mode) {
						this.mode = newMode;
					}
				})
			},
		});
	</script>
@endsection
