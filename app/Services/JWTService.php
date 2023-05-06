<?php

namespace App\Services;

use App\Core\CoreService;
use App\DTO\Auth\LoginDTO;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\JWTServiceInterface;
use Exception;
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
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
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
        if (!auth()->check()) {
            throw new Exception("Пользователь не авторизован");
        }

        $token = auth()->refresh();

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    /**
     * Method logout
     * 
     * @return void
     */
    public function logout(): void
    {
        if (!auth()->check()) {
            throw new Exception("Пользователь не авторизован");
        }

        auth()->logout();
    }

    /**
     * Method me
     * 
     * @return ?User
     */
    public function me(): ?User
    {
        if (!auth()->check()) {
            throw new Exception("Пользователь не авторизован");
        }

        return auth()->user();
    }
}
