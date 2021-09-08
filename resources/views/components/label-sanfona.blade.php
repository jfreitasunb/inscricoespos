@props(['value', 'icone'])

<label {{ $attributes->merge(['class' => 'block p-5 leading-normal cursor-pointer']) }}>
<span class="material-icons-outlined">{{ $icone }}</span>
{{ $value ?? $slot }}
</label>
