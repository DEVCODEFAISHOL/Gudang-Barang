@props(['disabled' => false, 'type' => 'text'])

<input
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge([
        'type' => $type,
        'class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
    ]) !!}
/>
