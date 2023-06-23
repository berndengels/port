<div class="row">
	<h5 class="m-0">Bitte überweisen Sie den ausgewiesenen Betrag auf folgendes Konto</h5>
	<table class="table table-sm mt-0">
		<tr>
			<td>Konto-Inhaber</td>
			<td>{{ $settings->name }}</td>
		</tr>
		<tr>
			<td>Bank-Institut</td>
			<td>{{ $settings->bank }}</td>
		</tr>
		<tr>
			<td>IBAN</td>
			<td>{{ $settings->iban }}</td>
		</tr>
		<tr>
			<td>BIC</td>
			<td>{{ $settings->bic}}</td>
		</tr>
	</table>
</div>
