<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::firstOrCreate(['id' => 1]);
        $form = $settings->form();
        return view('settings.index', compact('form'));
    }
    public function update(Request $request)
    {
    	$data = $request->validate([
    		'tax_value' => 'required|numeric'
    	]);    
    	$settings = Setting::first();
    	$settings->update($data);
    	return redirect('/settings');
    }
}
