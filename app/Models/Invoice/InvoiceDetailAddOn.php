<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class InvoiceDetailAddOn extends Model
{
    use HasUuids;

    protected $fillable = [
        'invoice_detail_id',
        'package_addon_id',
        'quantity',
        'quantity',
        'amount',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function invoiceDetail()
    {
        return $this->belongsTo(InvoiceDetail::class);
    }
}
