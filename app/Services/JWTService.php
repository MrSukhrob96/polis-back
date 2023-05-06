<?php

namespace App\Services;

use App\Core\CoreService;
use App\DTO\Auth\LoginDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\JWTServiceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class JWTService extends CoreService implements JWTServiceInterface
{

    public function __construct(UserRepositoryInterface $userRepository)
    {
        parent::__construct($userRepository);
    }

    /**
     * Method login
     * 
     * @param LoginDTO $dto
     */
    public function login(LoginDTO $dto): ?array
    {
        if (!$token = auth()->attempt($dto->toArray())) {
            throw new NotFoundHttpException("Пользователь не авторизован");
        }

        return [
            'accessToken' => $token,
            'tokenType' => 'bearer',
            'expiresIn' => auth()->factory()->getTTL() * 60
        ];
    }

    /**
     * Method refreshToken
     * 
     * @param string $refreshToken
     * @return array
     */
    public function refreshToken(string $refreshToken): ?array
    {
        $token = auth()->refresh();

        return [
            'accessToken' => $token,
            'tokenType' => 'bearer',
            'expiresIn' => auth()->factory()->getTTL() * 60
        ];
    }

    /**
     * Method logout
     * 
     * @return void
     */
    public function logout(): void
    {
        auth()->logout();
    }

    /**
     * Method me
     * 
     * @return ?User
     */
    public function me(): ?User
    {
        return auth()->user();
    }
}
