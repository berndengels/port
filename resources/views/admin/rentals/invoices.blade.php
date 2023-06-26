@extends('layouts.main')

@section('main')
	<div>
		<div class="index-header mt-3">
			<div>
			</div>
			<div></div>
		</div>
		<div class="mx-5 mt-3">
		</div>
		{{ $data->links() }}
		<table class="table w-full mt-3">
			<tr>
				<th>Objekt</th>
				<th>Zeit</th>
				<th>Von</th>
				<th>Bis</th>
				<th>Preis</th>
				<th><br></th>
			</tr>
			@foreach($data as $item)
				<tr>
					<td><a href="{{ route('admin.boatDates.show', $item) }}">{{ $item->boat->name }}</a></td>
					<td>{{ $item->period }}</td>
					<td>{{ $item->from->format('d.m.Y') }}</td>
					<td>{{ $item->until->format('d.m.Y') }}</td>
					<td>{{ $item->price }} €</td>
					<td>
						<x-nav-link href="{{ route('admin.boatDates.edit', $item) }}" icon="fas fa-edit" class="btn"
									title="Bearbeiten">
							<span class="hidden md:visible">Edit</span>
						</x-nav-link>
					</td>
				</tr>
			@endforeach
			<tr>
				<th colspan="9">
					<div class="mt-3 w-full text-red-700">Summe Preis: {{ $priceTotal }} €</div>
				</th>
			</tr>
		</table>
		{{ $data->links() }}
	</div>
@endsection
