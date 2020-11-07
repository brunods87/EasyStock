<?php

namespace App\Http\Controllers;

use App\Type;
use DataTables;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Type::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="/types/update/'.$row->id.'" title="Editar" class="edit btn btn-primary btn-sm mr-3"><i class="fas fa-edit"></i></a>';
                           $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" title="Eliminar" class="delete btn btn-primary btn-sm"><i class="fas fa-trash"></i></a>';
     
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('types/index');
    }

    public function create()
    {
        $type = new Type(); 
        $form = $type->form();
        return view('types.create', compact('form', 'type'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);
        Type::create($data);
        return redirect('/types');
    }

    public function edit($id)
    {
        $type = Type::findOrFail($id);
        $form = $type->form();
        return view('types.update', compact('form', 'type'));
    }

    public function update($id, Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);
        $type = Type::findOrFail($id);
        $type->update($data);
        return redirect('/types');
    }

    public function destroy(Request $request)
    {
        $id = $request['id'];
        $type = Type::findOrFail($id);
        if (count($type->materials) > 0){
            return ['msg' => 'O tipo tem materiais associados!'];
        }
        $type->delete();
        return ['msg' => 'O tipo foi eliminado'];
    }
}
