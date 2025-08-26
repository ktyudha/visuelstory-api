<?php

namespace App\Http\Services\Auth;

use App\Enums\AuthIdentifier\AuthIdentifierEnum;
use App\Enums\Guard\GuardEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Events\Auth\OtpRequested;
use App\Http\Repositories\Customer\CustomerRepository;
use App\Http\Services\WhatsApp\WhatsAppService;

class AuthCustomerService
{

    public function __construct(
        protected CustomerRepository $customerRepository,
        protected WhatsAppService $whatsAppService,
    ) {}

    public function sendOTPByWhatsApp(Request $request)
    {
        $validated =  $request->apiValidate([
            'whatsapp' => ['required'],
        ]);
        $whatsapp = normalizeWhatsapp($validated['whatsapp']);
        $otp = generateOTP();

        $payload = [
            'whatsapp' => $whatsapp,
            'otp_expires_at' => Carbon::now()->addMinutes(5)
        ];

        // Update or Create User
        $user = $this->customerRepository->updateOrCreate(['whatsapp' => $whatsapp], [...$payload, 'otp' => Hash::make($otp)]);

        // Send OTP via WhatsApp 
        $message = str_replace('{otp}', $otp, config('services.whatsapp.message'));
        $this->whatsAppService->sendMessage($whatsapp, $message);

        return $user;
    }

    public function verifyOtpByWhatsapp(Request $request)
    {
        $validated =  $request->apiValidate([
            'whatsapp' => ['required'],
            'otp' =>  ['required', 'digits:6'],
        ]);

        $whatsapp = normalizeWhatsapp($validated['whatsapp']);
        $otp = $validated['otp'];

        $user = $this->customerRepository->findUserAuth($whatsapp, AuthIdentifierEnum::WHATSAPP);

        if (!$user || !Hash::check($otp, $user->otp)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated',
            ], 401);
        }

        $token = $user->createToken('visuelstoryToken')->accessToken;

        return response()->json([
            'status' => 'Success',
            'message' => 'OTP verified successfully',
            'data' => $token,
        ], 200);
    }

    // AUTHENTICATION VIA EMAIL
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

        $user = $this->customerRepository->updateOrCreate(['email' => $email], [...$payload, 'otp' => Hash::make($otp)]);

        event(new OtpRequested([...$payload, 'otp' => $otp]));

        return $user;
    }

    public function verifyOtp(Request $request)
    {
        $validated =  $request->apiValidate([
            'email' => ['required', 'email'],
            'otp' =>  ['required', 'digits:6'],
        ]);

        $user = $this->customerRepository->findUserAuth($validated['email'], AuthIdentifierEnum::EMAIL);

        if (!$user || !Hash::check($validated['otp'], $user->otp)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated',
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
        if (Auth::guard(GuardEnum::CUSTOMER)->check()) {
            $user = Auth::guard(GuardEnum::CUSTOMER)->user();
            // $this->userRepository->removeOtp($user->id);
            $user->token()->revoke();
        }
    }

    public function getAuthenticatedUser()
    {

        if (Auth::guard(GuardEnum::CUSTOMER)->check()) {
            $user = Auth::guard(GuardEnum::CUSTOMER)->user();
            $role = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', class_basename($user)));
            $user->role = $role;
            return $user;
        }
    }
}
