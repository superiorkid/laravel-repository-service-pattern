<?php

namespace App\DTO;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

class UpdateTaskDTO extends DataTransferObject
{
    public ?string $title;
    public ?string $description;
    public ?int $category_id;

    #[CastWith(EnumCaster::class, enumType: TaskStatus::class)]
    public ?TaskStatus $status;

    #[CastWith(EnumCaster::class, enumType: TaskPriority::class)]
    public ?TaskPriority $priority;

    public ?string $due_date;
    public ?string $completed_at;
    public ?int $user_id;
}
