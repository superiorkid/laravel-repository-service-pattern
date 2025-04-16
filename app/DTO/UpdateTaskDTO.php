<?php

namespace App\DTO;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Spatie\DataTransferObject\DataTransferObject;
use Carbon\Carbon;

class UpdateTaskDTO extends DataTransferObject
{
    public ?string $title;
    public ?string $description;
    public ?int $category_id;
    public ?TaskStatus $status;
    public ?TaskPriority $priority;
    public ?Carbon $due_date;
    public ?Carbon $completed_at;
}
