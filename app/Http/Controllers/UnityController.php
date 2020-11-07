<?php

namespace App\Http\Controllers;

use App\Unity;
use DataTables;
use Illuminate\Http\Request;

class UnityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Unity::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="/unities/update/'.$row->id.'" title="Editar" class="edit btn btn-primary btn-sm mr-3"><i class="fas fa-edit"></i></a>';
                           $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" title="Eliminar" class="delete btn btn-primary btn-sm"><i class="fas fa-trash"></i></a>';
     
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('unities/index');
    }

    public function create()
    {
        $unity = new Unity(); 
        $form = $unity->form();
        return view('unities.create', compact('form', 'unity'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string'
        ]);
        Unity::create($data);
        return redirect('/unities');
    }

    public function edit($id)
    {
        $unity = Unity::findOrFail($id);
        $form = $unity->form();
        return view('unities.update', compact('form', 'unity'));
    }

    public function update($id, Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string'
        ]);
        $unity = Unity::findOrFail($id);
        $unity->update($data);
        return redirect('/unities');
    }

    public function destroy(Request $request)
    {
        $id = $request['id'];
        $unity = Unity::findOrFail($id);
        if (count($unity->materials) > 0){
            return ['msg' => 'A unidade tem materiais associados!'];
        }
        $unity->delete();
        return ['msg' => 'A unidade foi eliminada'];
    }
}
