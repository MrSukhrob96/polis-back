<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\User\CreateUserDTO;
use App\DTO\Auth\LoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Services\Interfaces\JWTServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(
        protected UserServiceInterface $userService,
        protected JWTServiceInterface $jWTService
    ) {
        $this->middleware('jwt.auth', ['except' => ['login', 'register']]);
    }

    /**
     * Method login
     * 
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $dto = new LoginDTO($request->validated());
            $data = $this->jWTService->login($dto);

            return response()->json([
                "status" => true,
                "body" => array(
                    "user" => new UserResource(auth()->user()),
                    ...$data
                ),
                "message" => "Успешно!"
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                "status" => true,
                "body" => [],
                "message" => $ex->getMessage()
            ], 400);
        }
    }

    /**
     * Method register
     * 
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $data = new CreateUserDTO($request->validated());
            $user = $this->userService->createUser($data);

            return response()->json([
                "status" => true,
                "body" => $user,
                "message" => "Успешно!"
            ], 201);
        } catch (\Exception $ex) {
            return response()->json([
                "status" => false,
                "body" => [],
                "message" => $ex->getMessage()
            ], 400);
        }
    }

    /**
     * Method refreshToken
     * 
     * @return JsonResponse
     */
    public function refreshToken(Request $request): JsonResponse
    {
        try {
            $token = JWTAuth::fromUser(auth()->user());
            $data = $this->jWTService->refreshToken($token);

            return response()->json([
                "status" => true,
                "body" => $data,
                "message" => "Успешно!"
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                "status" => true,
                "body" => [],
                "message" =>  $ex->getMessage()
            ], 400);
        }
    }

    /**
     * Method me
     * 
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        try {
            $user = $this->jWTService->me();

            return response()->json([
                "status" => true,
                "body" => new UserResource($user),
                "message" => "Успешно!"
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                "status" => false,
                "body" => [],
                "message" => $ex->getMessage()
            ], 400);
        }
    }

    /**
     * Method logout
     * 
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        try {
            $this->jWTService->logout();

            return response()->json([
                "status" => true,
                "body" => [],
                "message" => "Успешно!"
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                "status" => true,
                "body" => [],
                "message" => $ex->getMessage()
            ], 400);
        }
    }
}
