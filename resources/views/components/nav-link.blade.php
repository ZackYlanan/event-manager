@props(['active'])

@php
    $classes =
        $active ?? false
            ? // update the style in active state, used the self-center to fix the pills height
            'inline-flex items-center self-center px-4 py-1 bg-amber-100 text-sm font-medium leading-5 text-amber-950 rounded-full focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center self-center px-4 py-2 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
