<?php

namespace App\Models;

use App\Models\Invoice\Invoice;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Uuid;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'whatsapp',
        'address',
        'otp',
        'otp_expires_at',
    ];

    protected $hidden = [
        'otp',
        'otp_expires_at',
        'tokens',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp' => 'hashed',
            'otp_expires_at' => 'datetime',
        ];
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
