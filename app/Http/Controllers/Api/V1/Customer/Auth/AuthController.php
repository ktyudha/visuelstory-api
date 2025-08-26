<?php

namespace App\Http\Controllers\Api\V1\Customer\Auth;

use App\Enums\Guard\GuardEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Customer\CustomerResource;
use App\Http\Services\Auth\AuthCustomerService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        protected AuthCustomerService $authCustomerService
    ) {}

    public function sendOtp(LoginRequest $request)
    {
        // $user = $this->authCustomerService->sendOTPByEmail($request);
        $user = $this->authCustomerService->sendOTPByWhatsApp($request);

        return response()->json([
            'status' => 'Success',
            'message' => 'Please Check Your WhatsApp for the OTP code.',
            'data' => new CustomerResource($user)
        ]);
    }

    public function verifyOtp(Request $request)
    {
        return  $this->authCustomerService->verifyOtpByWhatsapp($request);
    }

    public function logout()
    {
        $this->authCustomerService->centralizedLogout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function user()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil diambil!',
            'data' => new CustomerResource(auth()->guard(GuardEnum::CUSTOMER)->user()),
        ]);
    }
}
