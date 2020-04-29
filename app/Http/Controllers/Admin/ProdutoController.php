<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\Models\Produto;

class ProdutoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('paginas.produtos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $produto = Produto::find($id);
        return view('paginas.produtos.edit',['produto' => $produto]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            DB::beginTransaction();
            $produto = Produto::find($id);
            $produto->denominacao = strtoupper($request->denominacao);
            $produto->preco = $request->preco;
            $produto->codigo_barra = $request->codigo_barra;
            $produto->unidade = $request->unidade;
            $produto->laboratorio_fornecedor = $request->laboratorio_fornecedor;
            $produto->save();

            DB::commit();

            return redirect()->route('produtos.index')->with('toast_success', 'Produto alterado com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('produtos.index')->with('toast_error', 'Ops! Produto não alterado !');
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
        //
    }

    public function indexDatatable() {

        $produtos = Produto::select([
            'produtos.id','produtos.codigo_barra','produtos.denominacao',
            'produtos.unidade','produtos.preco','produtos.laboratorio_fornecedor'
        ])->orderBy('produtos.denominacao');

        return Datatables::of($produtos)
            ->addColumn('btnedit', 'paginas.produtos.actionedit')
            ->rawColumns(['btnedit'])
            ->toJson();

    }

    public function importarArquivoView() {
        return view('paginas.produtos.importa');
    }


    public function importarArquivo(Request $request)
    {
        $aquivo_temp = $_FILES['arquivo']['tmp_name'];
        $dados = file($aquivo_temp);

        if($dados) {

            foreach ($dados as $linha) {
                $linha = trim($linha);
                $valor = explode(';', $linha);

                // Busca produto pelo codigo de barras
                $produto_busca = Produto::where('codigo_barra',$valor[2])->first();

                if($produto_busca) {
                    $produto_busca->denominacao = $valor[1];
                    $produto_busca->laboratorio_fornecedor = $valor[3];
                    $produto_busca->preco = $valor[4];
                    $produto_busca->unidade = $valor[5];
                    $produto_busca->save();
                } else {
                    $produto = new Produto();
                    $produto->codigo = $valor[0];
                    $produto->denominacao = $valor[1];
                    $produto->codigo_barra = $valor[2];
                    $produto->laboratorio_fornecedor = $valor[3];
                    $produto->preco = $valor[4];
                    $produto->unidade = $valor[5];
                    $produto->save();
                    }
                }

                return redirect()->route('produtos.index')->with('toast_success','Produtos importados com sucesso !');
            }

            else {
                return redirect()->route('produtos.index')->with('toast_error','O arquivo não foi enviado !');
            }

    }
}
