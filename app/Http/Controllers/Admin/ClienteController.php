<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClienteStoreRequest;
use App\Http\Requests\Admin\ClienteUpdateRequest;
use App\Models\Cidade;
use App\Models\Cliente;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Illuminate\Support\Facades\Auth;
use DateTime;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('paginas.clientes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cidades = Cidade::all();
        return view('paginas.clientes.create', compact('cidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienteStoreRequest $request)
    {

        try {

            DB::beginTransaction();
            $cliente = new Cliente();
            $cliente->nome = strtoupper($request->get('nome'));
            $cliente->nascimento = $request->get('nascimento');
            $cliente->cpf = $request->get('cpf');
            $cliente->rg = $request->get('rg');
            $cliente->celular = $request->get('celular');
            $cliente->telefone = $request->get('telefone');
            $cliente->endereco = strtoupper($request->get('endereco'));
            $cliente->bairro = strtoupper($request->get('bairro'));
            $cliente->cidade_id = $request->get('cidade_id');
            $cliente->user_criacao = Auth::user()->id;

            $cliente->save();

            DB::commit();

            return redirect()->route('clientes.index')->with('toast_success', 'Cliente cadastrado com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('clientes.index')->with('toast_error', 'Ops! Cliente não cadastrado !');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Cliente::find($id);
        $cidades = Cidade::all();
        return view('paginas.clientes.edit',compact('cliente','cidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClienteUpdateRequest $request, $id)
    {
        try {

            DB::beginTransaction();
            $cliente = Cliente::find($id);
            $cliente->nome = strtoupper($request->nome);
            $cliente->nascimento = $request->nascimento;
            $cliente->cpf = $request->cpf;
            $cliente->rg = $request->rg;
            $cliente->celular = $request->celular;
            $cliente->telefone = $request->telefone;
            $cliente->endereco = strtoupper($request->endereco);
            $cliente->bairro = strtoupper($request->bairro);
            $cliente->cidade_id = $request->cidade_id;

            $cliente->save();

            DB::commit();

            return redirect()->route('clientes.index')->with('toast_success', 'Cliente alterado com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('clientes.index')->with('toast_error', 'Ops! Cliente não alterada !');
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        if ($cliente)
            $cliente->delete();
    }


    public function indexClientes()
    {
        $clientes = Cliente::select([
            'clientes.id','clientes.nome','clientes.celular','clientes.rg',
            'clientes.cpf' , 'clientes.nascimento'
        ])
            ->orderBy('clientes.nome', 'desc');


            return Datatables::of($clientes)
            ->addColumn('btnedit', 'paginas.clientes.actionedit')
            ->addColumn('btndel', 'paginas.clientes.actiondel')
            //->addColumn('checkbox', '<input type="checkbox" name="check-multiplo[]" class="check-multiplo" value="{{ $id }}" />')
            ->rawColumns(['btnedit','btndel','checkbox'])
            ->toJson();
    }



    // PESQUISA DE CLIENTES COMBO SELECT 2 AJAX
    public function getClientesSelect(Request $request)
    {

        $search = $request->search;

        if ($search == '') {
            $clientes = Cliente::orderby('nome', 'asc')->select('id', 'nome')->limit(5)->get();
        } else {
            $clientes = Cliente::orderby('nome', 'asc')->select('id', 'nome')->where('nome', 'like', '%' . $search . '%')->limit(10)->get();
        }

        $response = array();
        foreach ($clientes as $cliente) {
            $response[] = array(
                "id" => $cliente->id,
                "text" => $cliente->id . ' - ' . $cliente->nome
            );
        }

        echo json_encode($response);
        exit;
    }

}
