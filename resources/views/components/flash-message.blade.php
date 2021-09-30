
<div class="flash-msg text-white px-6 py-4 border-0 rounded content-center text-center relative mb-4 {{ $css }}">
    <span class="text-xl inline-block align-middle">
        <i class="{{ $icon }}"></i>
    </span>
    <span class="inline-block align-middle ml-1">
        <b class="capitalize uppercase">{{ $type }}:</b> <span class="ml-2">{{ $text }}</span>
    </span>
    <button class="btn-msg-close absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none">
        <span>×</span>
    </button>
</div>

<script>
	const elemFlashMsg = document.querySelector('.flash-msg'),
        btnClose = elemFlashMsg.querySelector('button.btn-msg-close');

	btnClose.onclick = () => {
		elemFlashMsg.style.display = 'none';
    };
    @if($type !== 'error')
    window.setTimeout(function () {
	    elemFlashMsg.style.display = 'none';
    }, 3000);
    @endif
</script>
