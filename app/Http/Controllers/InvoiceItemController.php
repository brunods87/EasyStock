<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
    public function getItems(Request $request)
    {
        $data = $request->post();
        $invoice = Invoice::findOrFail($data['id']);
        return $invoice->invoice_items;
    }
}
