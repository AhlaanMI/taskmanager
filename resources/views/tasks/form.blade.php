<form method="POST" action="{{ $action }}">
    @csrf
    @if($method === 'PUT') @method('PUT') @endif

    <div class="mb-4">
        <label class="block font-medium">Task Name</label>
        <input name="name" class="w-full border rounded p-2" value="{{ old('name', $task->name ?? '') }}">
        @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
        <label class="block font-medium">Category</label>
        <select name="category_id" class="w-full border rounded p-2">
            @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ (old('category_id', $task->category_id ?? '') == $c->id) ? 'selected' : '' }}>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="block font-medium">Deadline</label>
        <input type="date" name="deadline" class="w-full border rounded p-2"
               value="{{ old('deadline', isset($task) ? $task->deadline->format('Y-m-d') : '') }}">
        @error('deadline') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
        <label class="block font-medium">Status</label>
        <select name="status" class="w-full border rounded p-2">
            @foreach(['pending','in_progress','completed','cancelled'] as $status)
                <option value="{{ $status }}" {{ (old('status', $task->status ?? '') == $status) ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </option>
            @endforeach
        </select>
    </div>

    @if(auth()->user()->isAdmin())
    <div class="mb-4">
        <label class="block font-medium">Assign to User</label>
        <select name="user_id" class="w-full border rounded p-2">
            @foreach($users as $u)
                <option value="{{ $u->id }}" {{ (old('user_id', $task->user_id ?? '') == $u->id) ? 'selected' : '' }}>
                    {{ $u->name }}
                </option>
            @endforeach
        </select>
    </div>
    @endif

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
</form>
