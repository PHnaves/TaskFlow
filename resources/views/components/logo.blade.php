{{-- Marca do TaskFlow. Use :inverted="true" sobre fundos escuros/coloridos. --}}
@props(['inverted' => false])

<span {{ $attributes->class(['inline-flex items-center gap-2.5']) }}>
    <span @class([
        'grid size-9 place-items-center rounded-[10px] text-white',
        'bg-linear-to-br from-indigo-500 to-violet-600 shadow-md shadow-indigo-500/30' => ! $inverted,
        'bg-white/15 ring-1 ring-white/30' => $inverted,
    ])>
        <svg viewBox="0 0 24 24" class="size-5" fill="currentColor" aria-hidden="true">
            <rect x="3.5" y="3.5" width="5" height="17" rx="1.6" />
            <rect x="10" y="3.5" width="5" height="11" rx="1.6" opacity=".85" />
            <rect x="16.5" y="3.5" width="4" height="14" rx="1.6" opacity=".7" />
        </svg>
    </span>
    <span @class(['text-[19px] font-semibold tracking-tight', 'text-white' => $inverted])>
        Task<span @class(['text-brand-ink' => ! $inverted, 'text-white/70' => $inverted])>Flow</span>
    </span>
</span>
