<?php

namespace App\Repositories;

use App\Core\CoreRepository;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends CoreRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * Method findByEmail 
     * 
     * @param string $email
     */
    public function findByEmail(string $email): ?User
    {
        return $this->model->query()->where("email", $email)->first();
    }
}
