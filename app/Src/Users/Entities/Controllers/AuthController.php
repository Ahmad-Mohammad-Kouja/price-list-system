<?php

namespace App\Src\Users\Entities\Controllers;

use App\Domain\Entities\Models\User;
use App\Http\Controllers\Controller;
use App\Src\Users\Entities\Requests\LoginRequest;
use App\Src\Users\Entities\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(protected User $user)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $user = $this->user->findByEmail($validatedData['email']);

        if (empty($user) || !Hash::check($validatedData['password'], $user->password)) {
            return response()->json(['message' => __('user.response_messages.invalid_credentials')], 400);
        }

        return response()->json([
            'data' => [
                'user' => UserResource::make($user),
                'token' => $user->createToken('auth_token')->plainTextToken,
            ]
        ]);
    }
}
