<?php

namespace App\Http\Controllers;

use App\JobProfit;
use Illuminate\Http\Request;

class JobProfitController extends Controller
{
    public function destroy(Request $request)
    {
    	$data = $request->post();    
    	$profit = JobProfit::findOrFail($data['id']);
    	$profit->delete();
    	return ['msg' => 'A receita foi eliminada'];
    }
}
