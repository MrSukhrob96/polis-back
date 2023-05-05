<?php

namespace App\Repositories\Interfaces;

use App\Core\Interfaces\RepositoryInetrface;
use App\Models\User;

interface UserRepositoryInterface extends RepositoryInetrface
{
    public function findByEmail(string $email): ?User;
}
