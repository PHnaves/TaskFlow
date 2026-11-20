{{-- Campo de formulário com rótulo, ícone opcional, dica e mensagem de erro. --}}
@props(['name', 'label', 'type' => 'text', 'icon' => null, 'hint' => null, 'value' => null])

<div>
    <label for="{{ $name }}" class="label">{{ $label }}</label>

    <div class="relative">
        @if ($icon)
            <span class="pointer-events-none absolute inset-y-0 left-0 grid w-11 place-items-center text-muted">
                <x-icon :name="$icon" class="size-[18px]" />
            </span>
        @endif

        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            @if ($type !== 'password') value="{{ old($name, $value) }}" @endif
            {{ $attributes->class(['input', 'pl-11' => $icon, 'input-error' => $errors->has($name)]) }}
        >
    </div>

    @error($name)
        <p class="field-error">
            <x-icon name="alert" class="mt-0.5 size-4 shrink-0" />
            <span>{{ $message }}</span>
        </p>
    @elseif ($hint)
        <p class="field-hint">{{ $hint }}</p>
    @enderror
</div>
