<?php

namespace App\Services;

use App\DTO\CreateTaskDTO;
use App\DTO\UpdateCategoryDTO;
use App\DTO\UpdateTaskDTO;
use App\Repositories\TaskRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class TaskService
{
    protected TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository){
        $this->taskRepository = $taskRepository;
    }

    public function create(CreateTaskDTO $createTaskDTO): JsonResponse {
        $task = $this->taskRepository->findByTitle($createTaskDTO->title);
        if ($task) {
            return response()->json(["success" => false, "message" => "Task already exists!"], 409);
        }

        try {
            $slug = Str::slug($createTaskDTO->title);
            $this->taskRepository->save($createTaskDTO, $slug);

            return response()->json(["success" => true, "message" => "Task created!"], 200);
        } catch (\Exception $error) {
            return response()->json(["success" => false, "message" => $error->getMessage()], 500);
        }
    }

    public function listAll(): JsonResponse {
        try {
            $tasks = $this->taskRepository->findMany();

            return response()->json([
                "success" => true,
                "message" => "Get tasks successfully.",
                "data" => $tasks
            ]);
        } catch (\Exception $error) {
            return response()->json(["success" => false, "message" => $error->getMessage()], 500);
        }
    }

    public function findById(int $id): JsonResponse {
        try {
            $task = $this->taskRepository->findById($id);
            if (!$task) {
                return response()->json(["success" => false, "message" => "Task not found!"], 404);
            }

            return response()->json(["success" => true, "message" => "Get task successfully!", "data" => $task], 200);
        }catch (\Exception $error) {
            return response()->json(["success" => false, "message" => $error->getMessage()], 500);
        }
    }

    public function delete(int $task_id): JsonResponse {
        $task = $this->taskRepository->findById($task_id);
        if (!$task) {
            return response()->json(["success" => false, "message" => "Task not found!"], 404);
        }

        try {
            $this->taskRepository->delete($task);

            return response()->json(["success" => true, "message" => "Task deleted successfully!"], 200);
        } catch (\Exception $error) {
            return response()->json(["success" => false, "message" => $error->getMessage()], 500);
        }
    }

    public function update(int $task_id, UpdateTaskDTO $updateTaskDTO): JsonResponse {
        $task = $this->taskRepository->findById($task_id);
        if (!$task) {
            return response()->json(["success" => false, "message" => "Task not found!"], 404);
        }

        try {
            $slug = $task->title !== $updateTaskDTO->title ? Str::slug($updateTaskDTO->title) : $task->slug;
            $this->taskRepository->update($task, $updateTaskDTO, $slug);

            return response()->json(["success" => true, "message" => "Task updated successfully!"], 200);
        } catch (\Exception $error) {
            return response()->json(["success" => false, "message" => $error->getMessage()], 500);
        }
    }
}
