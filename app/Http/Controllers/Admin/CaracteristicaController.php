<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\Models\Caracteristica;

class CaracteristicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('paginas.caracteristicas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('paginas.caracteristicas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();
            $caracteristica = new Caracteristica();
            $caracteristica->denominacao = strtoupper($request->denominacao);

            $caracteristica->save();

            DB::commit();

            return redirect()->route('caracteristicas.index')->with('toast_success', 'Caracteristica cadastrado com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('caracteristicas.index')->with('toast_error', 'Ops! Caracteristica não cadastrado !');
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
        $caracteristica = Caracteristica::find($id);
        return view('paginas.caracteristicas.edit', compact('caracteristica'));
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
            $caracteristica = Caracteristica::find($id);

            $caracteristica->denominacao = strtoupper($request->denominacao);

            $caracteristica->save();

            DB::commit();

            return redirect()->route('caracteristicas.index')->with('toast_success', 'Caracteristica alterado com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('caracteristicas.index')->with('toast_error', 'Ops! Caracteristica não alterada !');
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
        $caracteristica = Caracteristica::find($id);

        if ($caracteristica->encomendas->count() > 0) {
            return redirect()->route('caracteristicas.index')->with('toast_error', 'Ops! Caracteristica não pode ser excluída !');
        } else {
            $caracteristica->delete();
        }
    }

    public function indexDatatable(){

        $caracteristicas =  Caracteristica::select(['id', 'denominacao']);

        return Datatables::of($caracteristicas)
            ->addColumn('btnedit', 'paginas.caracteristicas.actionedit')
            ->addColumn('btndel', 'paginas.caracteristicas.actiondel')
            ->rawColumns(['btnedit','btndel'])
            ->toJson();
    }
}
