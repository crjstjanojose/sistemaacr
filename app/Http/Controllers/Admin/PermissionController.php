<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use DataTables;
use DB;
use App\Http\Requests\Admin\PermissionStoreRequest;
use App\Http\Requests\Admin\PermissionUpdateRequest;

class PermissionController extends Controller
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
        return view('paginas.permissoes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('paginas.permissoes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionStoreRequest $request)
    {
        try {

            DB::beginTransaction();
            $permission = new Permission();
            $permission->name = $request->get('name');

            $permission->save();

            DB::commit();

            return redirect()->route('permissions.index')->with('toast_success', 'Permissão cadastrado com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('permissions.index')->with('toast_error', 'Ops! Permissão não cadastrado !');
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
        $permission = Permission::find($id);
        return view('paginas.permissoes.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionUpdateRequest $request, $id)
    {
        try {

            DB::beginTransaction();
            $permission = Permission::find($id);

            $permission->name = $request->get('name');

            $permission->save();

            DB::commit();

            return redirect()->route('permissions.index')->with('toast_success', 'Permissão alterado com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('permissions.index')->with('toast_error', 'Ops! Permissão não alterada !');
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

    public function indexDatatable(){

        $permissoes = Permission::select(['id', 'name']);

        return Datatables::of($permissoes)
            ->addColumn('btnedit', 'paginas.permissoes.actionedit')
            ->rawColumns(['btnedit'])
            ->toJson();
    }

}
