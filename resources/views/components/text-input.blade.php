@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-white border border-gray-300 w-full text-sm px-4 py-3 rounded-md outline-blue-500']) !!}>
