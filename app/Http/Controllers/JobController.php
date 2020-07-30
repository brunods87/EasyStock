<?php

namespace App\Http\Controllers;

use App\Employee;
use App\InvoiceItem;
use App\Job;
use App\JobExpense;
use App\JobProfit;
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
        $job = Job::create($data);
        return redirect('/jobs/view/'.$job->id);
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
        return redirect('/jobs/view/'.$job->id);
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
        $job = Job::findOrFail($job_id);
        $materials = isset($data['Material']) ?  $data['Material'] : false;
        $employees = isset($data['Employee']) ? $data['Employee'] : false;
        $profits = isset($data['Profit']) ? $data['Profit'] : false;

        //materials
        if ($materials){
            for($row = 0;$row < sizeof($materials['materialItem_id']);$row++) {
                $materialItem = InvoiceItem::find($materials['materialItem_id'][$row]);
                $expense_id = $materials['expense_id'][$row];
                $quantity = $materials['quantity'][$row];
                $total = $materialItem->priceWithDiscount() * $quantity;
                $material = $materialItem->material;
                if ($expense_id > 0){
                    $expense = JobExpense::findOrFail($expense_id);
                    if ($job->type == 'faturado' && $quantity > $expense->quantity){
                        $increment = $quantity - $expense->quantity;
                        if ($material->stock < $increment){
                            return redirect('jobs/view/'.$job_id)->with('error', 'Quantidade em stock insuficiente ['.$material->name.']');
                        }
                        $material->stock -= $increment;
                        $material->save();
                    }elseif($job->type == 'faturado' && $quantity < $expense->quantity){
                        $returnStock = $expense->quantity - $quantity;
                        $material->stock += $returnStock;
                        $material->save();
                    }
                    $expense->quantity = $quantity;
                    $expense->total = $total;
                    $expense->save();
                }else{
                    $expense = new JobExpense();
                    
                    if (!$materialItem->job && $job->type == 'faturado'){
                        if ($quantity > $material->stock){
                            return redirect('jobs/view/'.$job_id)->with('error', 'Quantidade em stock insuficiente ['.$material->name.']');
                        }
                        $material->stock -= $quantity;
                        $material->save();
                    }
                    $expense->linkMaterial($materialItem, $job_id, $quantity, $total);
                    $materialItem->job_id = $job_id;
                    $materialItem->save();
                }
                
            }
        }

        //employees
        if ($employees){
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
        }

        //profits
        if ($profits){
            for($row = 0;$row < sizeof($profits['total']);$row++){
                $profit_id = $profits['profit_id'][$row];
                $number = $profits['number'][$row];
                $date = $profits['date'][$row];
                $total = $profits['total'][$row];
                if ($number == null && $date == null && $total == null) continue;
                if ($profit_id > 0){
                    $profit = JobProfit::findOrFail($profit_id);
                }else{
                    $profit = new JobProfit();
                }
                $profit->job_id = $job_id;
                $profit->number = $number;
                $profit->date = $date;
                $profit->total = $total;
                $profit->save();
            }
        }
        return redirect('jobs/view/'.$job_id)->with('success', 'Folha de Obra guardada');
    }
}
