{{-- resources/views/components/nav-link-icon.blade.php --}}
@props(['active', 'icon' => null])

@php
    $classes = ($active ?? false)
                ? 'inline-flex flex-col items-center justify-center px-1 pt-1 text-sm font-medium leading-5 text-red-500 focus:outline-none group hover:bg-gray-50'
                : 'inline-flex flex-col items-center justify-center px-1 pt-1 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-red-500 focus:outline-none focus:text-red-500 group hover:bg-gray-50';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if ($icon)
        <iconify-icon icon="{{ $icon }}" width="25" height="25" class="mb-px {{ $active ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}"></iconify-icon>
    @endif
    <span class="{{ $active ? 'text-red-500' : 'text-gray-500 group-hover:text-red-500' }}">
        {{ $slot }}
    </span>
</a>
