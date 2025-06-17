@extends('layouts.main')

@section('main')
	<div>
		<div class="index-header mt-3 p-0">
			<div class="float-start">
				<x-btn-create route="{{ route('admin.configPriceComponents.create') }}"/>
			</div>
			<div class="float-end"></div>
		</div>
		{{ $data->links() }}
		<x-table :items="$data" :fields="['Betrifft','Name','Key','Service','Preis pro Einheit','RangeUnit','Ab','Bis','Preis in €']" hasActions isSmall>
			@foreach($data as $item)
				<tr>
					@bindData($item)
					<x-td field="name"/>
					<td class="pt-0">
						@if($item->entities->count() > 0)
							<ul class="list-group list-group-sm mt-0">
								@foreach($item->entities as $entity)
									<li title="{{ $entity->model }}"
										class="list-group-item list-group-item-primary fst-italic">
										{{ __($entity->model) }}
									</li>
								@endforeach
							</ul>
						@endif
					</td>
					<x-td field="key"/>
					<x-td field="service.name"/>
					<x-td field="priceType.name"/>
					<x-td field="unitRangeType.name"/>
					<x-td field="unit_from" :append="['unitRangeType.name']"/>
					<x-td field="unit_until" :append="['unitRangeType.name']"/>
					<x-td field="unit_price" :append="['priceType.name']"/>
					<x-action routePrefix="admin.configPriceComponents" edit delete/>
					@endBindData
				</tr>
			@endforeach
		</x-table>
		<!--table class="table w-auto mt-3 mx-2 dt-left">
            <tr>
                <th>Betrifft</th>
                <th>Name</th>
                <th>Key</th>
                <th>Service</th>
                <th>Preis Typ</th>
                <th colspan="2"><br></th>
            </tr>
            @foreach($data as $item)
			<tr class="bottomBorder">
				<td>
@if($item->entities->count() > 0)
				<ul>
@foreach($item->entities as $entity)
					<li title="{{ $entity->model }}">
                                    {{ __($entity->model) }}
					</li>

				@endforeach
				</ul>

			@endif
			</td>
			<td>{{ $item->name }}</td>
                    <td>{{ $item->key }}</td>
                    <td>{{ $item->service?->name }}</td>
                    <td>{{ $item->priceType->name }}</td>
                    <td>
                        <x-nav-link href="{{ route('admin.configPriceComponents.edit', $item) }}" icon="fas fa-edit" class="btn" title="Bearbeiten">
                            <span class="hidden md:visible">Edit</span>
                        </x-nav-link>
                    </td>
                    <td>
                        <x-form action="{{ route('admin.configPriceComponents.destroy', $item) }}"
                                class="m-0 p-0">
                            @method('delete')
			<x-form-submit icon="fas fa-trash-alt" inline class="mt-0 btn-red delSoft">
				<span class="hidden md:visible">
					Löschen
				</span>
			</x-form-submit>
		</x-form>
	</td>
</tr>

		@endforeach
		</table-->

		{{ $data->links() }}
	</div>
@endsection
