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
		for($i = 0; $i < sizeof($data['material_id']); $i++) {
			if ($data['quantity'][$i] > 0){
				$item = new InvoiceItem();
				$item->invoice_id = $invoice_id;
				$item->material_id = $data['material_id'][$i];
				$item->quantity = $data['quantity'][$i];
				$item->discount_1 = $data['discount_1'][$i];
				$item->discount_2 = $data['discount_2'][$i];
				$item->job_id = $data['job'][$i];
				$item->save();
			}
		}

		return redirect('invoices/view/'.$invoice_id);
    }

}
