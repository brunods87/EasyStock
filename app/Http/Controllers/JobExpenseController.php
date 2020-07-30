<?php

namespace App\Http\Controllers;

use App\JobExpense;
use Illuminate\Http\Request;

class JobExpenseController extends Controller
{
    public function destroy(Request $request)
    {
    	$data = $request->post();    
    	$expense = JobExpense::findOrFail($data['id']);

  		if ($expense->expense_jobable->getMorphClass() == 'App\InvoiceItem'){
  			if ($expense->job->type == 'faturado'){
	  			$material = $expense->expense_jobable->material;
	  			$material->stock += $expense->quantity;
	  			$material->save();
	  		}
	  		$item = $expense->expense_jobable; 
	  		$item->job_id = null;
	  		$item->save();
  		}
    	$expense->delete();
    	return ['msg' => 'O elemento foi eliminado'];
    }
}
