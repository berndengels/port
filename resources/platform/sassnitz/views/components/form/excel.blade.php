<x-form method="post" :action="$action" class="mt-0 pt-0">
	<x-form-input type="hidden" name="from" :default="$from ?? null"/>
	<x-form-input type="hidden" name="until" :default="$until ?? null"/>
	<div class="row gx-3 justify-content-end">
		<div class="col-auto p-0">
			<x-nav-link
					role="buttom"
					:href="$routeDownload"
					class="btn btn-sm btn-secondary no-hide-text"
					target="_blank"
					title="Excel-Datei runterladen"
			><i class="far fa-file-excel"></i><span class="ms-2">Excel</span></x-nav-link>
		</div>
		<div class="col-auto ps-1-0">
			<x-form-submit
					name="submit"
					class="btn btn-sm btn-secondary"
					icon="fas fa-shipping-fast"
			>Sende Excel an
			</x-form-submit>

		</div>
		<div class="col-auto ps-1 mt-0">
			<x-form-input
					placeholder="an @Adresse"
					type="email"
					name="email"
					autocomplete="email"
					inline
					required
			/>
		</div>
	</div>
</x-form>
