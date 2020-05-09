<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EncomendaStoreRequest;
use App\Http\Requests\Admin\EncomendaUpdateRequest;
use App\Models\Caracteristica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use DB;
use DateTime;
use App\Models\Encomenda;
use App\Models\Produto;

class EncomendaController extends Controller
{

    public function __construct()
    {
        //$this->middleware(['permission:'], ['only' => ['']]);
        $this->middleware(['permission:encomendas-listar-pendentes'], ['only' => ['index','indexDatatablePendentes']]);
        $this->middleware(['permission:encomendas-listar-solicitadas'], ['only' => ['indexSolicitadas','indexDatatablesSolicitadas']]);
        $this->middleware(['permission:encomendas-listar-entregues'], ['only' => ['indexEntregues','indexDatatablesEntregues']]);

        $this->middleware(['permission:encomendas-criar'], ['only' => ['create','store']]);
        $this->middleware(['permission:encomendas-editar'], ['only' => ['edit','update']]);
        $this->middleware(['permission:encomendas-excluir'], ['only' => ['destroy']]);

        $this->middleware(['permission:encomendas-comprar'], ['only' => ['confirmaMultiplasCompras','confirmarCompraMulti']]);
        $this->middleware(['permission:encomendas-cancelar-compra'], ['only' => ['cancelaMultiplasCompras','cancelarCompra']]);

        $this->middleware(['permission:encomendas-entregar'], ['only' => ['multEntregar','confirmaEntrega']]);
        $this->middleware(['permission:encomendas-cancelar-entrega'], ['only' => ['cancelaMultiplasEntregas','cancelaEntrega']]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('paginas.encomendas.pendentes.index');
    }

    public function indexSolicitadas()
    {
        return view('paginas.encomendas.solicitadas.indexsolicitada');
    }

    public function indexEntregues()
    {
        return view('paginas.encomendas.entregues.indexentregues');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $caracteristicas = Caracteristica::all();
        return view('paginas.encomendas.pendentes.create', compact('caracteristicas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EncomendaStoreRequest $request)
    {

        if($request->produto_id == 0) {
            return redirect()->back()->with('toast_warning', 'Informe o produto !');
        }

        try {

            DB::beginTransaction();
            $encomenda = new Encomenda;
            $encomenda->nome = strtoupper($request->nome);
            $encomenda->contato = $request->contato;
            $encomenda->quantidade = $request->quantidade;
            $encomenda->preco = $request->preco;
            $encomenda->previsao = $request->previsao;
            $encomenda->tipo_encomenda = $request->tipo_encomenda;
            $encomenda->user_criacao = Auth::user()->id;
            $encomenda->produto_id = $request->produto_id;
            $encomenda->caracteristica_id = $request->caracteristica_id;
            $encomenda->save();

            DB::commit();

            return redirect()->route('encomendas.index')->with('toast_success', 'Encomenda cadastrada com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('encomendas.index')->with('toast_error', 'Ops! Encomenda não cadastrada !');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $encomenda = Encomenda::find($id);
        $caracteristicas = Caracteristica::all();
        //$produto = Produto::find($encomenda->produto_id);
        //return view('paginas.encomendas.edit',['encomenda' => $encomenda,'produto' => $produto]);

        return view('paginas.encomendas.pendentes.edit', ['encomenda' => $encomenda,'caracteristicas' => $caracteristicas]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EncomendaUpdateRequest $request, $id)
    {

        try {

            DB::beginTransaction();
            $encomenda = Encomenda::find($id);
            $encomenda->nome = strtoupper($request->nome);
            $encomenda->contato = $request->contato;
            $encomenda->quantidade = $request->quantidade;
            $encomenda->preco = $request->preco;
            $encomenda->previsao = $request->previsao;
            $encomenda->tipo_encomenda = $request->tipo_encomenda;
            $encomenda->produto_id = $request->produto_id;
            $encomenda->caracteristica_id = $request->caracteristica_id;
            $encomenda->user_alteracao = Auth::user()->id;
            $encomenda->save();

            DB::commit();

            return redirect()->route('encomendas.index')->with('toast_success', 'Encomenda alterada com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('encomendas.index')->with('toast_error', 'Ops! Encomenda não alterada !');
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
        $encomenda = Encomenda::find($id);
        if ($encomenda)
            $encomenda->delete();
    }


    // CARREGA AS ENCOMENDAS PENDENTES
    public function indexDatatablePendentes()
    {

        $encomendas = Encomenda::select([
            'encomendas.id', 'encomendas.nome', 'produtos.denominacao',
            'encomendas.quantidade', 'encomendas.created_at',
            'encomendas.tipo_encomenda','users.name',
            'caracteristicas.denominacao as caracteristica'
        ])
            ->join('users', 'users.id', '=', 'encomendas.user_criacao')
            ->join('produtos', 'produtos.id', '=', 'encomendas.produto_id')
            ->join('caracteristicas', 'caracteristicas.id', '=', 'encomendas.caracteristica_id')
            ->whereIn('situacao_pedido', ['Pendente'])
            ->orderBy('encomendas.id', 'desc');

        return Datatables::of($encomendas)
            ->addColumn('btnedit', 'paginas.encomendas.pendentes.actionedit')
            ->addColumn('btndel', 'paginas.encomendas.pendentes.actiondel')
            ->addColumn('checkbox', '<input type="checkbox" name="check-multiplo[]" class="check-multiplo" value="{{ $id }}" />')
            ->rawColumns(['btnedit', 'btndel', 'checkbox'])
            ->toJson();
    }


    // CARREGA AS ENCOMENDAS SOLICITADAS
    public function indexDatatablesSolicitadas()
    {

        $encomendas = Encomenda::select([
            'encomendas.id', 'encomendas.nome', 'produtos.denominacao',
            'encomendas.quantidade', 'encomendas.created_at',
            'encomendas.tipo_encomenda','users.name',
            'caracteristicas.denominacao as caracteristica'
        ])
            ->join('users', 'users.id', '=', 'encomendas.user_criacao')
            ->join('produtos', 'produtos.id', '=', 'encomendas.produto_id')
            ->join('caracteristicas', 'caracteristicas.id', '=', 'encomendas.caracteristica_id')
            ->whereIn('situacao_pedido', ['Solicitado'])
            ->orderBy('encomendas.id', 'desc');

        return Datatables::of($encomendas)
            //->addColumn('btnedit', 'paginas.encomendas.solicitadas.actionedit')
            //->addColumn('btndel', 'paginas.encomendas.solicitadas.actiondel')
            ->addColumn('checkbox', '<input type="checkbox" name="check-multiplo[]" class="check-multiplo" value="{{ $id }}" />')
            ->rawColumns(['checkbox'])
            ->toJson();
    }

    // CARREGA AS ENCOMENDAS ENTREGUES
    public function indexDatatablesEntregues()
    {

        $encomendas = Encomenda::select([
            'encomendas.id', 'encomendas.nome', 'produtos.denominacao',
            'encomendas.quantidade', 'encomendas.created_at', 'encomendas.previsao',
            'encomendas.tipo_encomenda','users.name'
        ])
            ->join('users', 'users.id', '=', 'encomendas.user_criacao')
            ->join('produtos', 'produtos.id', '=', 'encomendas.produto_id')

            ->whereIn('situacao_pedido', ['Entregue'])
            ->orderBy('encomendas.id', 'desc');

        return Datatables::of($encomendas)
            //->addColumn('btnedit', 'paginas.encomendas.solicitadas.actionedit')
            //->addColumn('btndel', 'paginas.encomendas.solicitadas.actiondel')
            ->addColumn('checkbox', '<input type="checkbox" name="check-multiplo[]" class="check-multiplo" value="{{ $id }}" />')
            ->rawColumns(['checkbox'])
            ->toJson();
    }





    // PESQUISA DE ITENS COMBO SELECT 2 AJAX
    public function getProdutosSelect(Request $request)
    {

        $search = $request->search;

        if ($search == '') {
            $produtos = Produto::orderby('denominacao', 'asc')->select('id', 'denominacao')->limit(5)->get();
        } else {
            $produtos = Produto::orderby('denominacao', 'asc')->select('id', 'denominacao')->where('denominacao', 'like', '%' . $search . '%')->limit(100)->get();
        }

        $response = array();
        foreach ($produtos as $produto) {
            $response[] = array(
                "id" => $produto->id,
                "text" => $produto->denominacao
            );
        }

        echo json_encode($response);
        exit;
    }

    // AUTLIZAÇÃO DAS ENCOMENDAS DE PENDENTES PARA SOLICITADAS
    public function confirmaMultiplasCompras(Request $request)
    {
        $encomendas_ids = $request->input('id');
        $encomendas = Encomenda::whereIn('id', $encomendas_ids);

        if ($encomendas->count() > 0) {
            foreach ($encomendas_ids as $encomenda) {
                $this->confirmarCompraMulti($encomenda);
            }
        }
    }

    private function confirmarCompraMulti($id)
    {
        $encomenda = Encomenda::find($id);
        if ($encomenda->situacao_pedido == 'Solicitado') {
            return redirect()->route('encomendas.index')->with('toast_warning', 'Encomenda já solicitada anteriormente !');
        } else {

            try {

                DB::beginTransaction();
                $encomenda->situacao_pedido = 'Solicitado';
                $encomenda->user_solicitacao = Auth::user()->id;
                $encomenda->save();

                DB::commit();
            } catch (exception $e) {
                DB::rollback();
            }
        }
    }


    public function cancelaMultiplasCompras(Request $request)
    {
        $encomendas_ids = $request->input('id');
        $encomendas = Encomenda::whereIn('id', $encomendas_ids);

        if ($encomendas->count() > 0) {
            foreach ($encomendas_ids as $encomenda) {
                $this->cancelarCompra($encomenda);
            }
        }
    }

    private function cancelarCompra($id)
    {
        $encomenda = Encomenda::find($id);
        if ($encomenda->situacao_pedido == 'Pendente') {
            return redirect()->route('encomendas.index')->with('toast_warning', 'Encomenda já pendente !');
        } else {

            try {

                DB::beginTransaction();
                $encomenda->situacao_pedido = 'Pendente';
                $encomenda->user_solicitacao = null;
                $encomenda->save();

                DB::commit();
            } catch (exception $e) {
                DB::rollback();
            }
        }
    }

    public function multEntregar(Request $request)
    {
        $encomendas_ids = $request->input('id');
        $encomendas = Encomenda::whereIn('id', $encomendas_ids);

        if ($encomendas->count() > 0) {
            foreach ($encomendas_ids as $encomenda) {
                $this->confirmaEntrega($encomenda);
            }
        }
    }

    private function confirmaEntrega($id)
    {
        $encomenda = Encomenda::find($id);
        if ($encomenda->situacao_pedido == 'Entregue') {
            return redirect()->route('encomendas.index')->with('toast_warning', 'Encomenda já entregue !');
        } else {

            try {

                DB::beginTransaction();
                $data = new DateTime();
                $encomenda->situacao_pedido = 'Entregue';
                $encomenda->user_solicitacao =  Auth::user()->id;
                $encomenda->entrega = $data;
                $encomenda->save();

                DB::commit();
            } catch (exception $e) {
                DB::rollback();
            }
        }
    }



    public function cancelaMultiplasEntregas(Request $request)
    {
        $encomendas_ids = $request->input('id');
        $encomendas = Encomenda::whereIn('id', $encomendas_ids);

        if ($encomendas->count() > 0) {
            foreach ($encomendas_ids as $encomenda) {
                $this->cancelaEntrega($encomenda);
            }
        }
    }

    private function cancelaEntrega($id)
    {
        $encomenda = Encomenda::find($id);
        if ($encomenda->situacao_pedido == 'Solicitado') {
            return redirect()->route('encomendas.index')->with('toast_warning', 'Encomenda já Solicitada !');
        } else {

            try {

                DB::beginTransaction();
                $encomenda->situacao_pedido = 'Solicitado';
                $encomenda->user_solicitacao =  null;
                $encomenda->entrega = null;
                $encomenda->save();

                DB::commit();
            } catch (exception $e) {
                DB::rollback();
            }
        }
    }

}
