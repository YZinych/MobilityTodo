<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\TaskRequest;
use App\Services\TaskService;
use App\Task;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class TasksController extends Controller
{
    protected $service;

    /**
     * TasksController constructor.
     * @param TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
        $this->middleware('auth');
        $this->service = $taskService;
    }

    /**
     * Returns current user's tasks list
     *
     * @return JsonResponse
     *
     * @response {
     *   "success": true,
     *   "tasks": [
     *     {
     *       "id": 1,
     *       "title": "Task 1",
     *       "description": "Description 1",
     *       "status": 0,
     *       "created_at": "2023-09-20 12:34:56",
     *     },
     *     {
     *       "id": 2,
     *       "title": "Task 2",
     *       "description": "Description 2",
     *       "status": 1,
     *       "created_at": "2023-09-21 09:15:00",
     *     }
     *   ]
     * }
     *
     * @throws AuthenticationException If User not Authorized (401).
     *
     * @status 200 OK
     * @status 401 Unauthorized
     */
    public function list()
    {
        $tasks = $this->service->getUserTasks();

        return $this->jsonResponse(['tasks' => $tasks]);
    }

    /**
     * Update existing task.
     *
     * @param TaskRequest $request Validated request
     * @param Task $task Model to update
     *
     * @return JsonResponse
     *
     * @request {
     *   "title": "Updated Task",
     *   "description": "Updated description",
     *   "status": 1
     * }
     *
     * @response {
     *   "success": true,
     *   "task": {
     *     "id": 1,
     *     "title": "Updated Task",
     *     "description": "Updated description",
     *     "status": 1,
     *     "created_at": "2023-09-20 12:34:56",
     *   }
     * }
     *
     * @throws ModelNotFoundException Task not found (404).
     * @throws AuthorizationException Access denied (403).
     *
     * @status 200 OK
     * @status 404 Not Found
     * @status 403 Forbidden
     */
    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        $this->service->saveValidated($request, $task);

        return $this->jsonResponse(['task' => $task]);
    }

    /**
     * Toggle task status
     *
     * @param TaskRequest $request Validated request
     * @param Task $task Model to update
     *
     * @return JsonResponse
     *
     * @request {
     *   "status": 1
     * }
     *
     * @response {
     *   "success": true,
     *   "task": {
     *     "id": 1,
     *     "title": "My Task",
     *     "description": "Task description",
     *     "status": 1,
     *     "created_at": "2023-09-20 12:34:56",
     *   }
     * }
     *
     * @throws ModelNotFoundException Task not found (404).
     * @throws AuthorizationException Access denied (403).
     *
     * @status 200 OK
     * @status 404 Not Found
     * @status 403 Forbidden
     */
    public function toggleStatus(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        $this->service->toggleValidated($request, $task);

        return $this->jsonResponse(['task' => $task]);
    }

    /**
     * Create new task
     *
     * @param TaskRequest $request Validated request
     *
     * @return JsonResponse
     *
     * @request {
     *   "title": "Updated Task",
     *   "description": "Updated description",
     * }
     *
     * @response {
     *   "success": true,
     *   "task": {
     *     "id": 1,
     *     "title": "My Task",
     *     "description": "Task description",
     *     "status": 0,
     *     "created_at": "2023-09-20 12:34:56",
     *   }
     * }
     *
     * @throws ValidationException Validation Failed 422.
     *
     * @status 201 Created
     * @status 422 Unprocessable Entity
     * @status 403 Forbidden
     */
    public function store(TaskRequest $request)
    {
        $this->authorize('create', Task::class);
        $task = $this->service->storeValidated($request);

        return $this->jsonResponse(['task' => $task]);
    }

    /**
     * Gets task data
     *
     * @param Task $task Model to show
     *
     * @return JsonResponse
     *
     * @response {
     *   "success": true,
     *   "task": {
     *     "id": 1,
     *     "title": "My Task",
     *     "description": "Task description",
     *     "status": 0,
     *     "created_at": "2023-09-20 12:34:56",
     *   }
     * }
     *
     * @throws ModelNotFoundException Task not found (404).
     * @throws AuthorizationException Access denied (403).
     *
     * @status 200 OK
     * @status 404 Not Found
     * @status 403 Forbidden
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return $this->jsonResponse(['task' => $task]);
    }

    /**
     * Remove the task
     *
     * @param Task $task Model to remove
     *
     * @return JsonResponse
     *
     * @response {
     *   "success": true,
     *   "message": "Task deleted successfully."
     * }
     *
     * @throws ModelNotFoundException Task not found (404).
     * @throws AuthorizationException Access denied (403).
     *
     * @status 200 OK
     * @status 404 Not Found
     * @status 403 Forbidden
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return $this->jsonResponse(['message' => 'Task deleted successfully']);
    }

    /**
     * Json response builder
     *
     * @param array $data
     * @param bool $success
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function jsonResponse($data = [], $success = true, $statusCode = 200)
    {
        return response()->json(
            array_merge(['success' => $success], $data),
            $statusCode
        );
    }
}
