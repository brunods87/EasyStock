<?php

namespace App\Http\Controllers;

use App\Material;
use DataTables;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Material::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" title="Editar" class="edit btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>';
     
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('materials/index');
    }

    public function create()
    {
        $material = new Material(); 
        $form = $material->form();
        return view('materials.create', compact('form', 'material'));
    }
}
