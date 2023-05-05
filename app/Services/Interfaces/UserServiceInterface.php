<?php

namespace App\Services\Interfaces;

use App\DTO\User\CreateUserDTO;

interface UserServiceInterface
{
    public function createUser(CreateUserDTO $data);
}
