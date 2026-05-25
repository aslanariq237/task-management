{{-- @props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a> --}}
@props(['active' => false])

<a {{ $attributes->merge([
    'class' => '
        flex items-center gap-3 px-4 py-3.5 text-[15px] font-medium rounded-2xl 
        transition-all duration-200
        ' . ($active 
            ? 'bg-blue-600 text-white shadow-md hover:bg-blue-700' 
            : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900'
        )
    ])
}}>
    {{ $slot }}
</a>