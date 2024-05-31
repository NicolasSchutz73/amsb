@props(['active'])

@php
    $classes = ($active ?? false)
                ? 'hover:text-red-500 block w-full px-4 py-2 text-start text-sm leading-5 text-red-500 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out'
                : 'hover:text-red-500 block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
