<?php

namespace App\Http\Controllers;

use App\Exports\InvoiceExport;
use App\Invoice;
use DataTables;
use Excel;
use Illuminate\Http\Request;
use PDF;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Invoice::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('supplier_id', function($row){
                        return $row->supplier->name;
                    })
                    ->addColumn('materials', function($row){
                        return count($row->invoice_items);
                    })
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="'.route('invoices.view', ['id' => $row->id]).'" title="Visualizar" class="view btn btn-primary btn-sm mr-2"><i class="fas fa-eye"></i></a>';
                           $btn .= '<a href="'.route('invoices.update', ['id' => $row->id]).'" title="Editar" class="edit btn btn-primary btn-sm mr-2"><i class="fas fa-edit"></i></a>';
                           $btn .= '<a href="'.route('invoices.exportPdf', ['id' => $row->id]).'" title="PDF" class="pdf btn btn-primary btn-sm mr-2"><i class="fas fa-file-pdf"></i></a>';
                           $btn .= '<a href="'.route('invoices.exportExcel', ['id' => $row->id]).'" title="Excel" class="excel btn btn-primary btn-sm mr-2"><i class="fas fa-file-excel"></i></a>';
                           $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" title="Eliminar" class="delete btn btn-primary btn-sm"><i class="fas fa-trash"></i></a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('invoices/index');
    }

    public function create()
    {
        $invoice = new Invoice(); 
        $form = $invoice->form();
        return view('invoices.create', compact('form', 'invoice'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'number' => 'required',
            'supplier_id' => 'required',
            'date' => 'required|string',
            'total' => 'nullable|numeric'
        ]);
        $invoice = Invoice::create($data);
        return redirect('/invoices/view/'.$invoice->id);
    }

    public function view($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->getTotal();
        return view('invoices.view', compact('invoice'));        
    }

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $form = $invoice->form();
        return view('invoices.update', compact('form', 'invoice'));
    }

    public function update($id, Request $request)
    {
        $data = $request->validate([
            'number' => 'required',
            'supplier_id' => 'required',
            'date' => 'required|string',
            'total' => 'nullable|numeric'
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->update($data);
        return redirect('/invoices/view/'.$invoice->id);
    }

    public function destroy(Request $request)
    {
        $id = $request['id'];
        $invoice = Invoice::findOrFail($id);
        foreach ($invoice->invoice_items as $item) {
            $item->delete();
        }
        $invoice->delete();
        return ['msg' => 'A fatura foi eliminada'];
    }

    public function exportPdf($id)
    {
        $data = Invoice::findOrFail($id);
        $pdf = PDF::loadView('invoices.pdf', compact('data'));
        return $pdf->download('FATURA_'.$data->number.'_'.$data->date.'.pdf');
    }

    public function exportExcel($id)
    {
        $invoice = Invoice::findOrFail($id);
        $name = 'FATURA_'.$invoice->number.'_'.$invoice->date.'.xlsx';
        $name = str_replace('/', '-', $name);
        return Excel::download(new InvoiceExport($invoice), $name);
    }
}
