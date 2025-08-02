<?php

namespace App\Http\Repositories\Customer;

use App\Http\Repositories\BaseRepository;
use App\Models\Customer;

class CustomerRepository extends BaseRepository
{
    public function __construct(protected Customer $customer)
    {
        parent::__construct($customer);
    }

    public function findUserAuth(string $email)
    {
        return $this->customer::where('email', $email)
            // ->where('otp', $otp)
            ->where('otp_expires_at', '>', now())
            // ->select(['id', 'email', 'name', 'otp', 'otp_expires_at'])
            ->limit(1)
            ->first();
    }

    public function removeOtp(string $userId)
    {
        $user = $this->customer::find($userId);
        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
        ]);
    }

    public function updateOrCreate(array $email, array $data)
    {
        return $this->customer::updateOrCreate($email, $data);
    }

    public function firstOrCreate(string $phone, array $data)
    {
        return $this->customer::firstOrCreate(['phone' => $phone], $data);
    }
}
