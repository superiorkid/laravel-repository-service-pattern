<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class SignInDTO extends DataTransferObject {
    public string $email;
    public string $password;
}
