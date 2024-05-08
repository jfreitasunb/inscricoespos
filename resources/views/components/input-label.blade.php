@props(['value'])

<label {{ $attributes->merge(['class' => 'text-sm mb-2 block']) }}>
    {{ $value ?? $slot }}
</label>
