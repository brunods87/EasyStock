<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Job;
use App\JobExpense;
use DataTables;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Job::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('client_id', function($row){
                        return $row->client->name;
                    })
                    ->addColumn('materials', function($row){
                        return count($row->job_expenses);
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
            'name' => 'required|string',
            'reference' => 'required|string',
            'client_id' => 'required',
            'date' => 'required|string',
            'address' => 'string',
            'observations' => 'string',
            'quote_value' => 'required|numeric',
            'type' => 'string',
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
            'name' => 'required|string',
            'reference' => 'required|string',
            'client_id' => 'required',
            'date' => 'required|string',
            'address' => 'string',
            'observations' => 'string',
            'quote_value' => 'required|numeric',
            'type' => 'string',
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

    public function getJobs(Request $request)
    {
        $jobs = Job::where('active', true)->get();
        return $jobs;        
    }

    public function storeItems(Request $request)
    {
        $request->validate([
            'jobID' => 'required',
        ]);
        $data = $request->post();
        $job_id = $data['jobID'];
        $materials = $data['Material'];
        $employees = $data['Employee'];
        //employees
        for($row = 0;$row < sizeof($employees['employee_id']);$row++) {
            $employee = Employee::findOrFail($employees['employee_id'][$row]);
            $expense_id = $employees['expense_id'][$row];
            $quantity = $employees['quantity'][$row];
            $quantity_extra = $employees['quantity_extra'][$row];
            $total = ($employee->value_hour * $quantity) + ($employee->value_extra_hour * $quantity_extra);
            if ($expense_id > 0){
                $expense = JobExpense::findOrFail($expense_id);
                $expense->quantity = $quantity;
                $expense->quantity_extra = $quantity_extra;
                $expense->total = $total;
                $expense->save();
            }else{
                $expense = new JobExpense();
                $expense->linkEmployee($employee, $job_id, $quantity, $quantity_extra, $total);
            }
        }
        return redirect('jobs/view/'.$job_id);
    }
}
