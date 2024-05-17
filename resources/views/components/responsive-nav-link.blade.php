@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'bg-red-100 block w-full ps-3 pe-4 py-2 border-l-4 border-red-500 text-start text-base font-medium text-red-500 focus:outline-none focus:text-red-600 focus:bg-red-100 focus:border-red-600 transition duration-150 ease-in-out'
                : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-red-500 hover:bg-gray-100 hover:border-gray-600 focus:outline-none focus:text-red-500 focus:bg-red-50 focus:border-red-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
