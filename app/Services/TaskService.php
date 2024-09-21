<?php

namespace App\Services;

use App\Http\Requests\TaskRequest;
use App\Task;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    public function getUserTasks()
    {
        return Task::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function saveValidated(TaskRequest $request, Task $task): void
    {
        $task->fill($request->only(['title', 'description', 'status']));
        $task->save();
    }

    public function toggleValidated(TaskRequest $request, Task $task)
    {
        $task->status = $request->input('status');
        $task->save();
    }

    public function storeValidated(TaskRequest $request): Task
    {
        return Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status' => 0,
            'user_id' => auth()->id(),
        ]);
    }

}
