<?php

namespace App\Models\Invoice;

use App\Models\Customer;
use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\Storage;

class Invoice extends Model
{
    use HasUuids;

    protected $fillable = [
        'customer_id',
        'invoice_number',
        'invoice_url',
        'transaction_status',
        'total_price',
        'proof',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getProofUrlAttribute()
    {
        if ($this->proof && Storage::exists($this->proof)) {
            return Storage::url($this->proof);
        }

        return null;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
