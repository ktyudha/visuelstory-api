<?php

namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(protected User $user)
    {
        parent::__construct($user);
    }

    public function findUserAuth(string $value, string $type = 'email')
    {
        return $this->user::where($type, $value)
            // ->where('otp', $otp)
            ->where('otp_expires_at', '>', now())
            // ->select(['id', 'email', 'name', 'otp', 'otp_expires_at'])
            ->limit(1)
            ->first();
    }

    public function removeOtp(string $userId)
    {
        $user = $this->user::find($userId);
        $user->update([
            'otp' => null,
            'otp_expires_at' => null,
        ]);
    }

    public function updateOrCreate(array $email, array  $data)
    {
        return $this->user::updateOrCreate($email, $data);
    }
}
