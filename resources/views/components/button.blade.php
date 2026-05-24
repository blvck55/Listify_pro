<button {{ $attributes->merge(['type' => 'submit', 'class' => 'lf-btn lf-btn-primary']) }}>
    {{ $slot }}
</button>
