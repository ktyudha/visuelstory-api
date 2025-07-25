<?php

namespace App\Http\Services\Auth;

use App\Enums\Guard\GuardEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Events\Auth\OtpRequested;
use Illuminate\Validation\Rule;
// use Illuminate\Http\JsonResponse;

class AuthService
{

    public function __construct(
        protected UserRepository $userRepository,
    ) {}

    public function sendOTPByEmail(Request $request)
    {
        $validated =  $request->apiValidate([
            'email' => ['required', 'email'],
        ]);

        $email = $validated['email'];
        $otp = generateOTP();

        $payload = [
            'email' => $email,
            'name' => explode('@', $email)[0],
            'otp_expires_at' => Carbon::now()->addMinutes(5)
        ];

        $user = $this->userRepository->updateOrCreate(['email' => $email], [...$payload, 'otp' => Hash::make($otp)]);

        event(new OtpRequested([...$payload, 'otp' => $otp]));

        return $user;
    }

    public function verifyOtp(Request $request)
    {
        $validated =  $request->apiValidate([
            'email' => ['required', 'email'],
            'otp' =>  ['required', 'digits:6'],
        ]);

        $user = $this->userRepository->findUserAuth($validated['email']);

        if (!$user || !Hash::check($validated['otp'], $user->otp)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired OTP',
            ], 401);
        }

        $token = $user->createToken('inbeworkTicketing')->accessToken;

        return response()->json([
            'status' => 'Success',
            'message' => 'OTP verified successfully',
            'data' => $token,
        ], 200);
    }

    public function centralizedLogout()
    {
        if (Auth::guard(GuardEnum::USER)->check()) {
            $user = Auth::guard(GuardEnum::USER)->user();
            // $this->userRepository->removeOtp($user->id);
            $user->token()->revoke();
        }
    }

    public function getAuthenticatedUser()
    {

        if (Auth::guard(GuardEnum::USER)->check()) {
            $user = Auth::guard(GuardEnum::USER)->user();
            $role = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', class_basename($user)));
            $user->role = $role;
            return $user;
        }
    }
}
