<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class UpdateCategoryDTO extends DataTransferObject
{
    public string $name;
    public ?string $description;
}
