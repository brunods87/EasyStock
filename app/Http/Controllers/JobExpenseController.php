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
  
    	$expense->delete();
    	return ['msg' => 'O elemento foi eliminado'];
    }
}
