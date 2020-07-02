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

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'reference' => 'required|string',
            'supplier_id' => 'required',
            'unity_id' => 'required',
            'category_id' => 'required',
            'type_id' => 'required',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'tax' => 'required',
            'stock' => 'required|numeric',
            'job_id' => 'nullable'
        ]);
        Material::create($data);
        return redirect('/materials');
    }

    public function edit($id)
    {
        $material = Material::findOrFail($id);
        $form = $material->form();
        return view('materials.update', compact('form', 'material'));
    }

    public function update($id, Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'reference' => 'required|string',
            'supplier_id' => 'required',
            'unity_id' => 'required',
            'category_id' => 'required',
            'type_id' => 'required',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'tax' => 'required',
            'stock' => 'required|numeric',
            'job_id' => 'nullable'
        ]);
        $material = Material::findOrFail($id);
        $material->update($data);
        return redirect('/materials');
    }

    public function destroy(Request $request)
    {
        $id = $request['id'];
        $material = Material::findOrFail($id);
        $material->delete();
        return ['msg' => 'O material foi eliminado'];
    }
}
