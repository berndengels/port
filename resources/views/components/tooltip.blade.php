<div id="{{ $id }}" class="absolute mx-2 cursor-pointer d-none">
	<div class="bg-dark white fs-6 rounded py-2 px-4 right bottom-0">
        <span class="txt">
            {!! $slot !!}
        </span>
		<svg class="absolute text-black h-2 left-0 ml-3 top-full" x="0px" y="0px" viewBox="0 0 255 255"
			 xml:space="preserve"><polygon class="fill-current" points="0,0 127.5,127.5 255,0"/></svg>
	</div>
</div>
