@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'opacity-0:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}>
