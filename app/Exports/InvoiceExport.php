<?php

namespace App\Exports;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InvoiceExport implements FromView, ShouldAutoSize
{
	protected $invoice;

    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('invoices.excel', [
            'data' => $this->invoice
        ]);
    }

}
