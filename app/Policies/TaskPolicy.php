<?php

namespace App\Policies;

use App\User;
use App\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Task $task)
    {
        return $this->isOwner($user->id, $task->user_id);
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Task $task)
    {
        return $this->isOwner($user->id, $task->user_id);
    }

    public function delete(User $user, Task $task)
    {
        return $this->isOwner($user->id, $task->user_id);
    }

    protected function isOwner(int $currentUserId, int $taskUserId)
    {
        return $currentUserId === $taskUserId;
    }
}
