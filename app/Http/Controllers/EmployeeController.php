<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use DataTables;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Employee::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="/employees/update/'.$row->id.'" title="Editar" class="edit btn btn-primary btn-sm mr-3"><i class="fas fa-edit"></i></a>';
                           $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" title="Eliminar" class="delete btn btn-primary btn-sm"><i class="fas fa-trash"></i></a>';
     
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('employees/index');
    }

    public function create()
    {
        $employee = new Employee(); 
        $form = $employee->form();
        return view('employees.create', compact('form', 'employee'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'number' => 'numeric',
            'admission_date' => 'required|string',
            'name' => 'required|string',
            'salary' => 'numeric',
            'value_hour' => 'numeric',
            'observations' => 'nullable|string'
        ]);
        Employee::create($data);
        return redirect('/employees');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $form = $employee->form();
        return view('employees.update', compact('form', 'employee'));
    }

    public function update($id, Request $request)
    {
        $data = $request->validate([
            'number' => 'numeric',
            'admission_date' => 'required|string',
            'name' => 'required|string',
            'salary' => 'numeric',
            'value_hour' => 'numeric',
            'observations' => 'nullable|string'
        ]);
        $employee = Employee::findOrFail($id);
        $employee->update($data);
        return redirect('/employees');
    }

    public function destroy(Request $request)
    {
        $id = $request['id'];
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return ['msg' => 'O employeee foi eliminado'];
    }
}
