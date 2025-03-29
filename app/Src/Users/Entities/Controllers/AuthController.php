<?php

namespace App\Src\Users\Entities\Controllers;

use App\Domain\Entities\Models\User;
use App\Src\Shared\Controllers\Controller;
use App\Src\Users\Entities\Requests\LoginRequest;
use App\Src\Users\Entities\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(protected User $user)
    {
    }

    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();
        $user = $this->user->findByEmail($validatedData['email']);

        if (empty($user) || !Hash::check($validatedData['password'], $user->password)) {
            return $this->failedResponse(message: __('global.response_messages.invalid_credentials'));
        }

        return $this->successResponse(data: [
            'user' => UserResource::make($user),
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return $this->successResponse();
    }
}
