@props(['value'])

<label {{ $attributes->merge(['class' => 'block p-5 leading-normal cursor-pointer']) }}>
    {{ $value ?? $slot }}
</label>
