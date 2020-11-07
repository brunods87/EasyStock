<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use DataTables;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Client::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="/clients/update/'.$row->id.'" title="Editar" class="edit btn btn-primary btn-sm mr-3"><i class="fas fa-edit"></i></a>';
                           $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" title="Eliminar" class="delete btn btn-primary btn-sm"><i class="fas fa-trash"></i></a>';
     
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      
        return view('clients/index');
    }

    public function create()
    {
        $client = new Client(); 
        $form = $client->form();
        return view('clients.create', compact('form', 'client'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'nif' => 'numeric',
            'address' => 'string'
        ]);
        Client::create($data);
        return redirect('/clients');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        $form = $client->form();
        return view('clients.update', compact('form', 'client'));
    }

    public function update($id, Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'nif' => 'numeric',
            'address' => 'string'
        ]);
        $client = Client::findOrFail($id);
        $client->update($data);
        return redirect('/clients');
    }

    public function destroy(Request $request)
    {
        $id = $request['id'];
        $client = Client::findOrFail($id);
        if (count($client->jobs) > 0){
            return ['msg' => 'O cliente tem obras associadas!'];
        }
        $client->delete();
        return ['msg' => 'O cliente foi eliminado'];
    }
}
