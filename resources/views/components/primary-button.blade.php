<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full py-3 px-4 text-sm font-semibold rounded text-white bg-blue-500 hover:bg-blue-600 focus:outline-none']) }}>
    {{ $slot }}
</button>