<?php

namespace App\Models\Invoice;

use App\Models\Package\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class InvoiceDetail extends Model
{
    use HasUuids;

    protected $fillable = [
        'invoice_id',
        'package_id',
        'quantity',
        'amount',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function invoiceDetailAddons()
    {
        return $this->hasMany(InvoiceDetailAddOn::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
