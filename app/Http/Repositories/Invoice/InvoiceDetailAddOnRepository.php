<?php

namespace App\Http\Repositories\Invoice;

use App\Http\Repositories\BaseRepository;
use App\Models\Invoice\InvoiceDetailAddOn;

class InvoiceDetailAddOnRepository extends BaseRepository
{
    public function __construct(protected InvoiceDetailAddOn $invoiceDetailAddOn)
    {
        parent::__construct($invoiceDetailAddOn);
    }

    public function insertMany(array $details)
    {
        return collect($details)->map(function ($detail) {
            return $this->invoiceDetailAddOn::create($detail);
        });
    }
}
