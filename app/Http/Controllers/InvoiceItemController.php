<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
    public function store(Request $request)
    {
		$request->validate([
            'invoiceID' => 'required',
        ]);  
		$data = $request->post();
		$invoice_id = intval($data['invoiceID']);
		$invoice = Invoice::findOrFail($invoice_id);
		InvoiceItem::where('invoice_id', $invoice_id)->delete();
		foreach ($data['quantity'] as $key => $value) {
			if ($value > 0){
				$item = new InvoiceItem();
				$item->invoice_id = $invoice_id;
				$item->material_id = $key;
				$item->quantity = $value;
				$item->save();
			}
		}

		return redirect('invoices/view/'.$invoice_id);
    }



    public function update(Request $request)
    {
		$request->validate([
            'invoiceID' => 'required',
        ]);  
		$data = $request->post();
		$invoice_id = intval($data['invoiceID']);
		InvoiceItem::where('invoice_id', $invoice_id)->delete();
		foreach ($data['quantity'] as $key => $value) {
			$item = new InvoiceItem();
			$item->invoice_id = $invoice_id;
			$item->material_id = $key;
			$item->quantity = $value;
			$item->save();
		}
		return redirect('invoices/view/'.$invoice_id);
    }
}
