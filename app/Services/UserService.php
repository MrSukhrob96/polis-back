<?php

namespace App\Services;

use App\Core\CoreService;
use App\DTO\User\CreateUserDTO;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;

class UserService extends CoreService implements UserServiceInterface
{
    public function __construct(UserRepositoryInterface $userRepository)
    {
        parent::__construct($userRepository);
    }

    /**
     * Method register
     * 
     * @param CreateUserDTO $data
     */
    public function createUser(CreateUserDTO $data)
    {
        $user = $this->repository->findByEmail($data->email);

        if ($user) {
            throw new \Exception("Логин пользователя существует!");
        }

        return $this->repository->create($data->toArray());
    }
}
