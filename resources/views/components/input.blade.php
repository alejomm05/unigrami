{{-- resources/views/components/input.blade.php --}}
@props(['disabled' => false, 'type' => 'text', 'value' => ''])

<input
    type="{{ $type }}"
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge([
        'class' => 'border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm',
    ]) }}
    value="{{ old($attributes->get('name'), $value) }}"
/>
