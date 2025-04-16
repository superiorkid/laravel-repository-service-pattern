<?php

namespace App\Services;

use App\DTO\CreateTaskDTO;
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
            $this->taskRepository->save(
                $createTaskDTO->title,
                $slug,
                $createTaskDTO->description,
            );

            return response()->json(["success" => true, "message" => "Task created!"], 200);
        } catch (\Exception $error) {
            return response()->json(["success" => false, "message" => $error->getMessage()], 500);
        }
    }
}
