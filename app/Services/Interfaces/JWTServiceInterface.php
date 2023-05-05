<?php

namespace App\Services\Interfaces;

use App\DTO\AUth\LoginDTO;

interface JWTServiceInterface
{
    public function login(LoginDTO $data);

    public function refreshToken(string $refreshToken);

    public function me();

    public function logout(): void;
}
