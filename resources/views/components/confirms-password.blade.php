@props(['title' => __('Confirm Password'), 'content' => __('For your security, please confirm your password to continue.'), 'button' => __('Confirm')])

@php
    $confirmableId = md5($attributes->wire('then'));
    $thenMethod    = $attributes->get('wire:then', '');
@endphp

{{--
    On click  → startConfirmingPassword (opens the modal below).
    On password-confirmed → call the target method directly via $wire instead of
    relying on wire:then + CustomEvent('then'), which breaks in Livewire 3 because
    the 'then' name collides with Promise.then and the event doesn't bubble through
    Livewire's delegation listener.
--}}
<span
    x-data
    x-ref="span"
    x-on:click="$wire.startConfirmingPassword('{{ $confirmableId }}')"
    x-on:password-confirmed.window="
        setTimeout(() => {
            if ($event.detail.id === '{{ $confirmableId }}') $wire.{{ $thenMethod }}()
        }, 250)
    "
>
    {{ $slot }}
</span>

@once
<x-dialog-modal wire:model.live="confirmingPassword">
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <x-slot name="content">
        {{ $content }}

        <div style="margin-top:1rem"
             x-data="{}"
             x-on:confirming-password.window="setTimeout(() => $refs.confirmable_password.focus(), 250)">
            <input type="password"
                   class="lf-input"
                   style="max-width:320px"
                   placeholder="{{ __('Password') }}"
                   autocomplete="current-password"
                   x-ref="confirmable_password"
                   wire:model="confirmablePassword"
                   wire:keydown.enter="confirmPassword" />

            @error('confirmable_password')
                <div class="lf-field-error" style="margin-top:.4rem">{{ $message }}</div>
            @enderror
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="stopConfirmingPassword" wire:loading.attr="disabled">
            {{ __('Cancel') }}
        </x-secondary-button>

        <x-button class="ms-3" wire:click="confirmPassword" wire:loading.attr="disabled">
            {{ $button }}
        </x-button>
    </x-slot>
</x-dialog-modal>
@endonce
