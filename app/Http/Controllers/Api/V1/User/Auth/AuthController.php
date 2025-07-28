<?php

namespace App\Http\Controllers\Api\V1\User\Auth;

use App\Enums\Guard\GuardEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function sendOtp(LoginRequest $request)
    {
        $user = $this->authService->sendOTPByEmail($request);

        return response()->json([
            'status' => 'Success',
            'message' => 'Please Check Your email for the OTP code.',
            'data' => new UserResource($user)
        ]);
    }

    public function verifyOtp(Request $request)
    {
        return  $this->authService->verifyOtp($request);
    }

    public function logout()
    {
        $this->authService->centralizedLogout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function user()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diambil!',
            'data' => new UserResource(auth()->guard(GuardEnum::USER)->user()),
        ]);
    }
}
