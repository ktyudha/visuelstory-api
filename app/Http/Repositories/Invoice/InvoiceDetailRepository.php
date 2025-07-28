<?php

namespace App\Http\Repositories\Invoice;

use App\Http\Repositories\BaseRepository;
use App\Models\Invoice\InvoiceDetail;

class InvoiceDetailRepository extends BaseRepository
{
    public function __construct(protected InvoiceDetail $invoiceDetail)
    {
        parent::__construct($invoiceDetail);
    }
}
