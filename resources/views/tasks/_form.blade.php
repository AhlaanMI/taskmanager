@php
    $deadlineValue = old('deadline');
    if ($deadlineValue === null && isset($task) && $task->deadline) {
        $deadlineValue = ($task->deadline instanceof \Illuminate\Support\Carbon)
            ? $task->deadline->format('Y-m-d')
            : \Illuminate\Support\Carbon::parse($task->deadline)->format('Y-m-d');
    }
@endphp

<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method === 'PUT')
        @method('PUT')
    @endif

    <div class="grid gap-6 md:grid-cols-2">
        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-200">Task name</label>
            <input
                type="text"
                name="name"
                value="{{ old('name', $task->name ?? '') }}"
                class="w-full rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-white shadow-inner shadow-black/20 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40"
                placeholder="Launch email campaign"
            >
            @error('name')
                <p class="text-xs font-medium text-rose-300">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-200">Category</label>
            <select
                name="category_id"
                class="w-full rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40"
            >
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $task->category_id ?? '') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="text-xs font-medium text-rose-300">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2 md:col-span-2">
            <label class="text-sm font-semibold text-slate-200">Description</label>
            <textarea
                name="description"
                rows="3"
                class="w-full rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40"
                placeholder="Add helpful context so teammates know what success looks like."
            >{{ old('description', $task->description ?? '') }}</textarea>
            @error('description')
                <p class="text-xs font-medium text-rose-300">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-200">Deadline</label>
            <input
                type="date"
                name="deadline"
                value="{{ $deadlineValue }}"
                class="w-full rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40"
            >
            @error('deadline')
                <p class="text-xs font-medium text-rose-300">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="text-sm font-semibold text-slate-200">Status</label>
            <select
                name="status"
                class="w-full rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40"
            >
                @foreach (['pending', 'in_progress', 'completed', 'cancelled'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $task->status ?? '') === $status)>
                        {{ ucwords(str_replace('_', ' ', $status)) }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <p class="text-xs font-medium text-rose-300">{{ $message }}</p>
            @enderror
        </div>

        @if (auth()->user()->isAdmin())
            <div class="space-y-2">
                <label class="text-sm font-semibold text-slate-200">Assign to teammate</label>
                <select
                    name="user_id"
                    class="w-full rounded-2xl border border-slate-800 bg-slate-900/70 px-4 py-3 text-sm text-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/40"
                >
                    <option value="">Select teammate</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected(old('user_id', $task->user_id ?? '') == $user->id)>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-xs font-medium text-rose-300">{{ $message }}</p>
                @enderror
            </div>
        @endif
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-indigo-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:bg-indigo-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14M12 5l7 7-7 7" />
            </svg>
            Save task
        </button>
        <a href="{{ route('tasks.index') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-700 px-6 py-3 text-sm font-semibold text-slate-200 transition hover:border-slate-500/80 hover:text-white">
            Cancel
        </a>
    </div>
</form>
