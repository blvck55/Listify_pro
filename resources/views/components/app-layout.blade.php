{{-- FILE: resources/views/components/app-layout.blade.php --}}
<x-layouts.app :pageTitle="$pageTitle ?? null">
    {{ $slot }}
</x-layouts.app>
