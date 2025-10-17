@php
    $levels = [
        'success' => ['Success', 'border-emerald-500/30 bg-emerald-500/10 text-emerald-200'],
        'error' => ['Error', 'border-rose-500/30 bg-rose-500/10 text-rose-200'],
        'warning' => ['Warning', 'border-amber-500/30 bg-amber-500/10 text-amber-100'],
        'info' => ['Heads up', 'border-sky-500/30 bg-sky-500/10 text-sky-100'],
        'status' => ['Notice', 'border-sky-500/30 bg-sky-500/10 text-sky-100'],
    ];
@endphp

<div class="space-y-3">
    @foreach ($levels as $key => [$title, $classes])
        @if (session($key))
            <div class="relative overflow-hidden rounded-2xl border {{ $classes }} p-4 shadow-lg shadow-slate-900/20">
                <div class="flex items-start gap-3">
                    <span class="mt-1 inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-white/5 text-sm font-semibold uppercase tracking-wide">
                        {{ substr($title, 0, 2) }}
                    </span>
                    <div class="flex-1 text-sm leading-relaxed">
                        <p class="font-semibold uppercase tracking-wide text-white/80">{{ $title }}</p>
                        <p class="mt-1 text-slate-100/80">{!! nl2br(e(session($key))) !!}</p>
                    </div>
                    <button type="button" class="text-xs text-white/50 transition hover:text-white" onclick="this.closest('div').remove()">
                        Dismiss
                    </button>
                </div>
            </div>
        @endif
    @endforeach

    @if ($errors->any())
        <div class="relative rounded-2xl border border-rose-500/30 bg-rose-500/10 p-5 text-sm text-rose-100 shadow-lg shadow-slate-900/30">
            <div class="flex items-start gap-3">
                <span class="mt-1 inline-flex h-10 w-10 items-center justify-center rounded-full border border-rose-400/40 bg-rose-500/30 text-sm font-semibold uppercase">!
                </span>
                <div class="flex-1">
                    <p class="font-semibold uppercase tracking-wide">Please fix the following</p>
                    <ul class="mt-3 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="text-xs text-white/50 transition hover:text-white" onclick="this.closest('div').remove()">
                    Dismiss
                </button>
            </div>
        </div>
    @endif
</div>
