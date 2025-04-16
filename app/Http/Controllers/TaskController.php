<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignUserToTaskRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function create(CreateTaskRequest $request): JsonResponse{
        return $this->taskService->create($request->toDTO());
    }

    public function list(): JsonResponse {
        return $this->taskService->listAll();
    }

    public function findById(int $task_id): JsonResponse {
        return $this->taskService->findById($task_id);
    }

    public function delete(int $task_id): JsonResponse {
        return $this->taskService->delete($task_id);
    }

    public function update(UpdateTaskRequest $request, int $task_id): JsonResponse {
        return $this->taskService->update($task_id, $request->toDTO());
    }

    public function assignTaskToUser(AssignUserToTaskRequest $request, int $task_id): JsonResponse {
        return $this->taskService->assignTaskToUser($request->toDTO(), $task_id);
    }

    public function myTasks(): JsonResponse {
        return $this->taskService->myTasks();
    }
}
