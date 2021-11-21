@if($label)
    <span {!! $attributes->merge([
//            'class' => 'h-10 text-gray-700 label sm:block sm:w-full md:inline-flex md:w-auto'
            'class' => 'text-gray-700 label'
        ]) !!}>{{ $label }}
    </span>
@endif
