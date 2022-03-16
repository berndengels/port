@extends('layouts.main')

@section('main')
    <div>
        {{ $data->links() }}
        <table class="table w-full mt-3">
            <tr>
                <th>ID</th>
                <th>Angebot</th>
                <th>Aktiv</th>
            </tr>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td rel="{{ $item->id }}">{!! $item->icon('enabled') !!}</td>
                </tr>
            @endforeach
        </table>

        {{ $data->links() }}
    </div>
@endsection

@push('inline-scripts')
<script>
    const token = $('[name="csrf-token"]').attr('content'),
    attr = "enabled",
	clOn = "text-green-600 fa-check-circle on",
    clOff = "text-red-600 fa-times off";

    $('i.switch').click(e => {
        var $t = $(e.target),
            toggle = $t.hasClass('on') ? 0 : 1,
            id = $t.parent('td').attr('rel'),
            url = "/admin/offers/toggle/" + id,
            data = {
			    "attribute": attr,
                "value": toggle,
                "_token": token
            }
        ;
		$.post(url, data).done(resp => {
			console.info(resp);
			if(resp[attr]) {
				$t.removeClass(clOff).addClass(clOn);
				$("#"+resp.name).show();
            } else {
				$t.removeClass(clOn).addClass(clOff);
				$("#"+resp.name).hide();
            }
        });
    });
</script>
@endpush
