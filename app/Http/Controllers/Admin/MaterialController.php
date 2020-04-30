<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SolicitacaoCreateRequest;
use App\Mail\SolicitacaoMail;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use DB;
use Illuminate\Support\Facades\Mail;
use stdClass;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('paginas.material.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('paginas.material.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SolicitacaoCreateRequest $request)
    {
        try {

            DB::beginTransaction();
            $material = new Material();
            $material->descricao = $request->get('descricao');
            $material->titulo = $request->get('titulo');
            $material->user_criacao = Auth::user()->id;

            $material->save();

            DB::commit();

            $parametros = new stdClass;
            $parametros->email = "financeiro@farmaciasaocristovao.com.br";
            $parametros->name = 'Solicitação ACR';
            $parametros->solicitante =  strtoupper(Auth::user()->name);
            $parametros->titulo =  strtoupper($material->titulo);
            $parametros->descricao = strtoupper($material->descricao);

            Mail::send(new SolicitacaoMail($parametros));


            return redirect()->route('materiais.index')->with('toast_success', 'Solicitação cadastrado com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('materiais.index')->with('toast_error', 'Ops! Solicitação não cadastrado !');
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
        //
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
        //
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

    public function indexMateriais()
    {
        $materiais = Material::select([
            'materiais.id','materiais.descricao','users.name','materiais.created_at','materiais.titulo'
        ])
            ->join('users', 'users.id', '=', 'materiais.user_criacao')
            ->whereIn('materiais.situacao', ['Pendente'])
            ->orderBy('materiais.id', 'desc');


            return Datatables::of($materiais)
            //->addColumn('btnedit', 'paginas.encomendas.solicitadas.actionedit')
            //->addColumn('btndel', 'paginas.encomendas.solicitadas.actiondel')
            ->addColumn('checkbox', '<input type="checkbox" name="check-multiplo[]" class="check-multiplo" value="{{ $id }}" />')
            ->rawColumns(['checkbox'])
            ->toJson();
    }





    // AUTLIZAÇÃO DAS SOLICITACOES PARA COMPRADAS
    public function confirmaMultiplasSolicitacoes(Request $request)
    {
        $materiais_ids = $request->input('id');
        $materiais = Material::whereIn('id', $materiais_ids);

        if ($materiais->count() > 0) {
            foreach ($materiais_ids as $material) {
                $this->confirmacaoMultipla($material);
            }
        }
    }

    private function confirmacaoMultipla($id)
    {
        $material = Material::find($id);

        if ($material->situacao == 'Atendida') {
            return redirect()->route('materiais.index')->with('toast_warning', 'Material já solicitado anteriormente !');
        } else {

            try {

                DB::beginTransaction();
                $material->situacao = 'Atendida';
                $material->user_compra = Auth::user()->id;
                $material->save();

                DB::commit();
            } catch (exception $e) {
                DB::rollback();
            }
        }
    }
}
