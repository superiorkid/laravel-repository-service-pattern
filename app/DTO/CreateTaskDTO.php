<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class CreateTaskDTO extends DataTransferObject
{
    public string $title;
    public ?string $description;
}
