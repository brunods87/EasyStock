<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use DataTables;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Supplier::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="'.route("suppliers.update", ["id" => $row->id]).'" title="Editar" class="edit btn btn-primary btn-sm mr-3"><i class="fas fa-edit"></i></a>';
                           $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" title="Eliminar" class="delete btn btn-primary btn-sm"><i class="fas fa-trash"></i></a>';
     
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('suppliers/index');
    }

    public function create()
    {
        $supplier = new Supplier(); 
        $form = $supplier->form();
        return view('suppliers.create', compact('form', 'supplier'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'discount' => 'nullable',
            'nif' => 'numeric'
        ]);
        Supplier::create($data);
        return redirect('/suppliers');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        $form = $supplier->form();
        return view('suppliers.update', compact('form', 'supplier'));
    }

    public function update($id, Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'discount' => 'nullable',
            'nif' => 'numeric'
        ]);
        $supplier = Supplier::findOrFail($id);
        $supplier->update($data);
        return redirect('/suppliers');
    }

    public function destroy(Request $request)
    {
        $id = $request['id'];
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return ['msg' => 'O fornecedor foi eliminado'];
    }
}
