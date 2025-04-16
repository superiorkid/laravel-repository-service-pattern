<?php

namespace App\Repositories;

use App\DTO\CreateTaskDTO;
use App\DTO\UpdateTaskDTO;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class TaskRepository
{
    public function findById(int $id): Task | null{
        return Task::query()->find($id);
    }

    public function findByTitle(string $title): Task | null {
        return Task::query()
            ->where('title', $title)
            ->first();
    }

    public function findManyByStatus(TaskStatus $status): Collection {
        return Task::query()
            ->where('status', $status->value)
            ->orderByDesc('due_date')
            ->get();
    }

    public function findByPriority(TaskPriority $priority): Collection {
        return Task::query()
            ->where('priority', $priority->value)
            ->orderByDesc('due_date')
            ->get();
    }

    public function findByCategoryId(int $category_id): Collection {
        return Task::query()
            ->where("category_id", $category_id)
            ->orderByDesc('created_at')
            ->get();
    }

    public function getCompletedTasks(): Collection {
        return Task::query()
            ->whereNotNull("completed_at")
            ->orderByDesc('completed_at')
            ->get();
    }

    public function getUncompletedTasks(): Collection {
        return Task::query()
            ->whereNull("completed_at")
            ->orderByDesc('due_date')
            ->get();
    }

    public function save(CreateTaskDTO $createTaskDTO): Task {
        return Task::query()->create([
            "title" => $createTaskDTO->title,
            "slug" => Str::slug($createTaskDTO->title),
            "description" => $createTaskDTO->description,
            "category_id" => $createTaskDTO->category_id,
        ]);
    }

    public function findMany(): Collection {
        return Task::query()
            ->orderByDesc('created_at')
            ->get();
    }

    public function delete(Task $task): void {
        $task->delete();
    }

    public function update(Task $task, UpdateTaskDTO $updateTaskDTO): void {
        $task->update([
            "title" => $updateTaskDTO->title ?? $task->title,
            "slug" => isset($updateTaskDTO->title) && $updateTaskDTO->title !== $task->title  ? Str::slug($updateTaskDTO->title) : $task->slug,
            "description" => $updateTaskDTO->description ?? $task->description,
            "category_id" => $updateTaskDTO->category_id ?? $task->category_id,
            "status" =>  $updateTaskDTO->status ?? $task->status,
            "priority" => $updateTaskDTO->priority ?? $task->priority,
            "completed_at" => $updateTaskDTO->completed_at ?? $task->completed_at ?? null,
            "due_date" => $updateTaskDTO->due_date ?? $task->due_date ?? null
        ]);
    }
}

