<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;
use DataTables;

class JobController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Job::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('materials', function($row){
                        return count($row->job_items);
                    })
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="'.route('jobs.view', ['id' => $row->id]).'" title="Visualizar" class="view btn btn-primary btn-sm mr-2"><i class="fas fa-eye"></i></a>';
                           $btn .= '<a href="'.route('jobs.update', ['id' => $row->id]).'" title="Editar" class="edit btn btn-primary btn-sm mr-2"><i class="fas fa-edit"></i></a>';
                            $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" title="Eliminar" class="delete btn btn-primary btn-sm"><i class="fas fa-trash"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('jobs/index');
    }

    public function create()
    {
        $job = new Job(); 
        $form = $job->form();
        return view('jobs.create', compact('form', 'job'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'number' => 'required|numeric',
            'supplier_id' => 'required',
            'date' => 'required|string',
            'total' => 'nullable|numeric'
        ]);
        Job::create($data);
        return redirect('/jobs');
    }

    public function view($id)
    {
        $job = Job::findOrFail($id);
        return view('jobs.view', compact('job'));        
    }

    public function edit($id)
    {
        $job = Job::findOrFail($id);
        $form = $job->form();
        return view('jobs.update', compact('form', 'job'));
    }

    public function update($id, Request $request)
    {
        $data = $request->validate([
            'number' => 'required|numeric',
            'supplier_id' => 'required',
            'date' => 'required|string',
            'total' => 'nullable|numeric'
        ]);

        $job = Job::findOrFail($id);
        $job->update($data);
        return redirect('/jobs');
    }

    public function destroy(Request $request)
    {
        $id = $request['id'];
        $job = Job::findOrFail($id);
        $job->delete();
        return ['msg' => 'A folha de obra foi eliminada'];
    }
}
