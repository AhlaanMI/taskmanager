<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    <div class="space-y-2">
        <label class="text-sm font-semibold text-slate-200">Category name</label>
        <input
            type="text"
            name="name"
            value="{{ old('name', $category->name ?? '') }}"
            required
            class="w-full rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40"
            placeholder="Marketing"
        >
        @error('name')
            <p class="text-xs font-medium text-rose-300">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label class="text-sm font-semibold text-slate-200">Description</label>
        <textarea
            name="description"
            rows="3"
            class="w-full rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40"
            placeholder="Summarise how this category is used."
        >{{ old('description', $category->description ?? '') }}</textarea>
        @error('description')
            <p class="text-xs font-medium text-rose-300">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label class="text-sm font-semibold text-slate-200">Status</label>
        <select
            name="status"
            class="w-full rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40"
        >
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(old('status', $category->status ?? 'active') === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
        @error('status')
            <p class="text-xs font-medium text-rose-300">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-indigo-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:bg-indigo-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14M12 5l7 7-7 7" />
            </svg>
            Save category
        </button>
        <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-700 px-6 py-3 text-sm font-semibold text-slate-200 transition hover:border-slate-500/80 hover:text-white">
            Cancel
        </a>
    </div>
</form>
