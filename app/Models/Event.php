<?php

namespace App\Models;

use App\Models\Invoice\Invoice;
use App\Models\Invoice\InvoiceDetail;
use App\Models\Package\Package;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Event extends Model
{
    use HasUuids;

    protected $fillable = [
        'invoice_detail_id',
        'note',
        'date',
        'location',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function invoiceDetail()
    {
        return $this->belongsTo(InvoiceDetail::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function invoice(): HasOneThrough
    {
        return $this->hasOneThrough(Invoice::class, InvoiceDetail::class, 'id', 'id', 'invoice_detail_id', 'invoice_id');
    }
}
