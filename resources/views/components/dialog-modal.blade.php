@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div style="padding:1.25rem 1.5rem">
        <div style="font-size:16px;font-weight:700;color:var(--text-primary);margin-bottom:.5rem">
            {{ $title }}
        </div>

        <div style="font-size:13px;color:var(--text-secondary)">
            {{ $content }}
        </div>
    </div>

    <div style="display:flex;flex-direction:row;justify-content:flex-end;gap:.6rem;
                padding:.875rem 1.5rem;background:var(--bg-card-hover);
                border-top:1px solid var(--border)">
        {{ $footer }}
    </div>
</x-modal>
