<?php

namespace App\Http\Repositories\Invoice;

use App\Http\Repositories\BaseRepository;
use App\Models\Invoice\Invoice;

class InvoiceRepository extends BaseRepository
{
    public function __construct(protected Invoice $invoice)
    {
        parent::__construct($invoice);
    }
}
