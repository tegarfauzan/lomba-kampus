<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn-secondary px-4 py-2']) }}>
    {{ $slot }}
</button>
