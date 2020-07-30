<?php

namespace App\Http\Controllers;

use App\InvoiceItem;
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
                    ->editColumn('supplier_id', function($row){
                        return $row->supplier->name;
                    })
                    ->editColumn('unity_id', function($row){
                        return $row->unity->name;
                    })
                    ->editColumn('type_id', function($row){
                        return $row->type->name;
                    })
                    ->editColumn('category_id', function($row){
                        return $row->category->name;
                    })
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="'.route('materials.update', ['id' => $row->id]).'" title="Editar" class="edit btn btn-primary btn-sm mr-3"><i class="fas fa-edit"></i></a>';
                            $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" title="Eliminar" class="delete btn btn-primary btn-sm"><i class="fas fa-trash"></i></a>';
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
        ]);

        $material = Material::findOrFail($id);
        $material->update($data);
        return redirect('/materials');
    }

    public function destroy(Request $request)
    {
        $id = $request['id'];
        $material = Material::findOrFail($id);
        if (!$material->isInUse()){
            $material->delete();
            return ['msg' => 'O material foi eliminado'];
        }else{
            return ['msg' => 'O material está a ser utilizado, não é possivel eliminá-lo!'];
        }
    }

    public function insert(Request $request)
    {
        if ($request->ajax()) {
            $data = Material::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('supplier_id', function($row){
                        return $row->supplier->name;
                    })
                    ->editColumn('unity_id', function($row){
                        return $row->unity->name;
                    })
                    ->editColumn('type_id', function($row){
                        return $row->type->name;
                    })
                    ->editColumn('category_id', function($row){
                        return $row->category->name;
                    })
                    ->addColumn('action', function($row){
   
                           $btn = '<button type="button" data-id="'.$row->id.'" class="btn btn-primary" onClick="insertMaterial(this)"><i class="fas fa-plus-square"></i></button>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('materials/index');
    }

    public function insertInJob($job_id, Request $request)
    {
        if ($request->ajax()) {
            $data = InvoiceItem::where('job_id', '!=', $job_id)->orWhereNull('job_id')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('supplier_id', function($row){
                        return $row->material->supplier->name;
                    })
                    ->editColumn('reference', function($row){
                        return $row->material->reference;
                    })
                     ->editColumn('name', function($row){
                        return $row->material->name;
                    })
                    ->editColumn('unity_id', function($row){
                        return $row->material->unity->name;
                    })
                    ->editColumn('type_id', function($row){
                        return $row->material->type->name;
                    })
                    ->editColumn('category_id', function($row){
                        return $row->material->category->name;
                    })
                    ->addColumn('price', function($row){
                        return number_format($row->priceWithDiscount(),2);
                    })
                    ->addColumn('discount', function($row){
                        return $row->getDiscount();
                    })
                    ->addColumn('stock', function($row){
                        return $row->material->stock;
                    })
                    ->addColumn('action', function($row){
   
                           $btn = '<button type="button" data-id="'.$row->id.'" class="btn btn-primary" onClick="insertMaterial(this)"><i class="fas fa-plus-square"></i></button>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    public function getDiscount(Request $request)
    {
        $data = $request->post();
        $material = Material::findOrFail($data['id']);
        return $material->getDiscount();
    }
}
