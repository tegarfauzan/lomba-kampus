<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-primary px-5 py-3']) }}>
    {{ $slot }}
</button>
