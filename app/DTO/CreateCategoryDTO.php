<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class CreateCategoryDTO extends DataTransferObject
{
    public string $name;
    public string $description;
}
