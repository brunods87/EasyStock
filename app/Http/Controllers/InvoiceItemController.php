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

		for($row = 0; $row < sizeof($data['material_id']); $row++) {
			if ($data['quantity'][$row] > 0){
				$item_id = $data['item_id'][$row];
				if ($item_id > 0){
					$item = InvoiceItem::findOrFail($item_id);
					$material = $item->material;
					if ($data['quantity'][$row] > $item->quantity && !$item->job_id){
						$increment = $data['quantity'][$row] - $item->quantity;
						$material->stock += $increment;
					}elseif($data['quantity'][$row] < $item->quantity && !$item->job_id){
						$withraw = $item->quantity - $data['quantity'][$row];
						$material->stock -= $withraw;
					}elseif($item->job_id && !$data['job'][$row]){
						$material->stock += $data['quantity'][$row];
						$item->job_expense->delete();
					}elseif(!$item->job_id && $data['job'][$row]){
						$material->stock -= $item->quantity;
						if ($material->stock < 0) $material->stock = 0;
					}
					$material->save();
				}else{
					$item = new InvoiceItem();	
					$item->invoice_id = $invoice_id;
					$item->material_id = $data['material_id'][$row];
				}
				$item->description = $data['description'][$row];
				$item->quantity = $data['quantity'][$row];
				$item->discount_1 = $data['discount_1'][$row];
				$item->discount_2 = $data['discount_2'][$row];
				$item->job_id = $data['job'][$row];
				$item->order = $row;
				$item->save();
				if ($item->job_id){
					$item->linkJob();	
				}elseif($item_id == 0){
					$material = $item->material;
					$material->stock += $item->quantity;
					$material->save();
				}

			}
		}

		return redirect('invoices/view/'.$invoice_id)->with('success', 'Fatura guardada');
    }

    public function destroy(Request $request)
    {
        $data = $request->post();
        $item = InvoiceItem::findOrFail($data['id']);
        if ($item->job){
        	$item->job_expense->delete();
        }else{
        	$material = $item->material;
        	$material->stock -= $item->quantity;
        	if ($material->stock < 0){
        		$material->stock = 0;
        	}
        	$material->save();
        }
        $item->delete();
        return ['msg' => 'O elemento foi eliminado'];
    }

}
