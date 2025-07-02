@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-3 text-sm font-medium text-indigo-600 bg-indigo-50 dark:bg-indigo-900/50 dark:text-indigo-300 rounded-md'
            : 'flex items-center px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>