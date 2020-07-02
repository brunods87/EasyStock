<?php

namespace App\Http\Controllers;

use App\Category;
use DataTables;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="/categories/update/'.$row->id.'" title="Editar" class="edit btn btn-primary btn-sm mr-3"><i class="fas fa-edit"></i></a>';
                           $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" title="Eliminar" class="delete btn btn-primary btn-sm"><i class="fas fa-trash"></i></a>';
     
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('categories/index');
    }

    public function create()
    {
        $category = new Category(); 
        $form = $category->form();
        return view('categories.create', compact('form', 'category'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);
        Category::create($data);
        return redirect('/categories');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $form = $category->form();
        return view('categories.update', compact('form', 'category'));
    }

    public function update($id, Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
        ]);
        $category = Category::findOrFail($id);
        $category->update($data);
        return redirect('/categories');
    }

    public function destroy(Request $request)
    {
        $id = $request['id'];
        $category = Category::findOrFail($id);
        $category->delete();
        return ['msg' => 'A categoria foi eliminada'];
    }
}
