<?php

namespace App\Repositories;

use App\DTO\CreateTaskDTO;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

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

    public function save(string $title, string $slug, ?string $description,): Task {
        return Task::query()->create([
            "title" => $title,
            "slug" => $slug,
            "description" => $description,
        ]);
    }
}
