<?php

namespace App\Models;

use App\Models\Invoice\Invoice;
use App\Models\Package\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Event extends Model
{
    use HasUuids;

    protected $fillable = [
        'package_id',
        'invoice_id',
        'note',
        'date',
        'location',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function customer(): HasOneThrough
    {
        return $this->hasOneThrough(Customer::class, Invoice::class, 'id', 'id', 'invoice_id', 'customer_id');
    }
}
