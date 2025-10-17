<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\Category;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Task::with(['category', 'user'])->orderByDesc('created_at');

        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $tasks = $query->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get(['id', 'name']);
        $users = auth()->user()->isAdmin()
            ? User::orderBy('name')->get(['id', 'name'])
            : User::whereKey(auth()->id())->get(['id', 'name']);

        return view('tasks.create', [
            'categories' => $categories,
            'users' => $users,
            'task' => new Task(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();

        if (!auth()->user()->isAdmin()) {
            $data['user_id'] = auth()->id();
        }

        $data['assignment_date'] = now();

        Task::create($data);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $categories = Category::orderBy('name')->get(['id', 'name']);
        $users = auth()->user()->isAdmin()
            ? User::orderBy('name')->get(['id', 'name'])
            : User::whereKey(auth()->id())->get(['id', 'name']);

        return view('tasks.edit', [
            'task' => $task,
            'categories' => $categories,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update($request->validated());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }
}
