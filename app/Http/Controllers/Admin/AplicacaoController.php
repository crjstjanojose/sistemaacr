<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AplicacaoStoreRequest;
use App\Http\Requests\Admin\AplicacaoUpdateRequest;
use App\Models\Aplicacao;
use App\User;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Illuminate\Support\Facades\Auth;

class AplicacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('paginas.aplicacoes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aplicadores = User::where('aplicador','=','Sim')->orderBy('name')->get();
        return view('paginas.aplicacoes.create',compact('aplicadores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AplicacaoStoreRequest $request)
    {
        //dd($request->all());

        if($request->produto_id == 0) {
            return redirect()->back()->with('toast_warning', 'Informe o produto !');
        }

        if($request->cliente_id == 0) {
            return redirect()->back()->with('toast_warning', 'Informe o cliente !');
        }

        try {

            DB::beginTransaction();
            $aplicacao = new Aplicacao;
            $aplicacao->produto_id = $request->produto_id;
            $aplicacao->cliente_id = $request->cliente_id;
            $aplicacao->user_aplicacao = $request->user_aplicacao;
            $aplicacao->data_aplicacao = $request->data_aplicacao;
            $aplicacao->data_venda = $request->data_venda;
            $aplicacao->documento_fiscal = $request->documento_fiscal;
            $aplicacao->observacao = $request->observacao;
            $aplicacao->user_criacao = Auth::user()->id;
            $aplicacao->save();

            DB::commit();

            return redirect()->route('aplicacoes.index')->with('toast_success', 'Aplicação cadastrada com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('aplicacoes.index')->with('toast_error', 'Ops! Aplicação não cadastrada !');
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
        $aplicadores = User::where('aplicador','=','Sim')->orderBy('name')->get();
        $aplicacao = Aplicacao::find($id);
        return view('paginas.aplicacoes.edit',compact('aplicadores','aplicacao'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AplicacaoUpdateRequest $request, $id)
    {


        if($request->produto_id == 0) {
            return redirect()->back()->with('toast_warning', 'Informe o produto !');
        }

        if($request->cliente_id == 0) {
            return redirect()->back()->with('toast_warning', 'Informe o cliente !');
        }

        try {

            DB::beginTransaction();
            $aplicacao = Aplicacao::find($id);
            $aplicacao->produto_id = $request->produto_id;
            $aplicacao->cliente_id = $request->cliente_id;
            $aplicacao->user_aplicacao = $request->user_aplicacao;
            $aplicacao->data_aplicacao = $request->data_aplicacao;
            $aplicacao->data_venda = $request->data_venda;
            $aplicacao->documento_fiscal = $request->documento_fiscal;
            $aplicacao->observacao = $request->observacao;
            $aplicacao->user_alteracao = Auth::user()->id;

            $aplicacao->save();

            DB::commit();

            return redirect()->route('aplicacoes.index')->with('toast_success', 'Aplicação alterado com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('aplicacoes.index')->with('toast_error', 'Ops! Aplicação não alterado !');
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
        $aplicacao = Aplicacao::find($id);
        if ($aplicacao)
            $aplicacao->delete();
    }


    public function indexAplicacoes()
    {
        $aplicacoes = Aplicacao::select([
            'aplicacoes.id','clientes.nome','users.name','produtos.denominacao',
            'aplicacoes.data_aplicacao'
        ])
            ->join('clientes', 'clientes.id', '=', 'aplicacoes.cliente_id')
            ->join('produtos', 'produtos.id', '=', 'aplicacoes.produto_id')
            ->join('users', 'users.id', '=', 'aplicacoes.user_aplicacao')
            ->orderBy('aplicacoes.id', 'desc');


            return Datatables::of($aplicacoes)
            ->addColumn('btnedit', 'paginas.aplicacoes.actionedit')
            ->addColumn('btndel', 'paginas.aplicacoes.actiondel')
            //->addColumn('checkbox', '<input type="checkbox" name="check-multiplo[]" class="check-multiplo" value="{{ $id }}" />')
            ->rawColumns(['btnedit','btndel'])
            ->toJson();
    }
}
