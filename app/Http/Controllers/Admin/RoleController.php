<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use DataTables;
use DB;
use App\User;
use App\Http\Requests\Admin\RoleStoreRequest;
use App\Http\Requests\Admin\RoleUpdateRequest;

class RoleController extends Controller
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
        return view('paginas.grupos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('paginas.grupos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleStoreRequest $request)
    {
        try {

            DB::beginTransaction();
            $role = new Role();
            $role->name = $request->get('name');

            $role->save();

            DB::commit();

            return redirect()->route('roles.index')->with('toast_success', 'Grupo cadastrado com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('roles.index')->with('toast_error', 'Ops! Grupo não cadastrado !');
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
        $role = Role::find($id);
        return view('paginas.grupos.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, $id)
    {
        try {

            DB::beginTransaction();
            $role = Role::find($id);

            $role->name = $request->get('name');

            $role->save();

            DB::commit();

            return redirect()->route('roles.index')->with('toast_success', 'Grupo alterado com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('roles.index')->with('toast_error', 'Ops! Grupo não alterado !');
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

        $permissoes = Role::select(['id', 'name']);

        return Datatables::of($permissoes)
            ->addColumn('btnedit', 'paginas.grupos.actionedit')
            ->addColumn('btnaddper', 'paginas.grupos.actionaddper')
            ->addColumn('btnremper', 'paginas.grupos.actionremper')
            ->addColumn('btnaddusr', 'paginas.grupos.actionaddusr')
            ->addColumn('btnremusr', 'paginas.grupos.actionremusr')
            ->rawColumns(['btnedit','btnaddper','btnremper','btnaddusr','btnremusr'])
            ->toJson();
    }


    // CARREGA A VIEW COM AS PERMISSÕES QUE PODEM SER LIBERADAS
    public function viewAdicionaPermissaoGrupo($id)
    {
        $role = Role::find($id);
        $opcoes = Permission::all();
        $permissions = [];
        foreach ($opcoes as $opcao) {
            if (!$role->hasPermissionTo($opcao)) {
                array_push($permissions, $opcao);
            }
        }

        return view('paginas.grupos.addpermissaogrupo', compact('permissions', 'role'));
    }

    // ATUALIZA AS PERMISÕES QUE FORAM LIBERADAS PARA O GRUPO
    public function adicionaPermissaoGrupo(Request $request, $id)
    {
        $role = Role::find($id);


        try {
            DB::beginTransaction();
            foreach ($request->permissions as $permission) {
                $role->givePermissionTo($permission);
            }
            DB::commit();
            return redirect()->route('roles.index')->with('toast_success', 'Acesso(s) adicionados com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('roles.index')->with('toast_error', 'Ops! Erro ao remover acessos do grupo !');
        }
    }

    // APRESENTA A VIEW PARA REMOVER PERMISSOES DO GRUPO
    public function viewRemovePermissaoGrupo($id)
    {
        $role = Role::find($id);
        $permissions = $role->permissions;
        return view('paginas.grupos.rempermissaogrupo', compact('permissions', 'role'));
    }


    // ATUALIZA AS PERMISSÕES RETIRADAS DO USUARIO
    public function removePermissaoGrupo(Request $request, $id)
    {

        $role = Role::find($id);

        try {
            DB::beginTransaction();
            foreach ($request->permissions as $permission) {
                $role->revokePermissionTo($permission);
            }
            DB::commit();
            return redirect()->route('roles.index')->with('toast_success', 'Acesso(s) excluídos com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('roles.index')->with('toast_error', 'Ops! Erro ao remover acessos do grupo !');
        }
    }

    // RETORNA A VIEW QUE ASSOCIA O USUARIO AO GRUPO DE ACESSO
    public function viewAdicionaUsuarioGrupo($id)
    {

        $role = Role::find($id);
        $usuarios = User::all();
        $users = [];
        foreach ($usuarios as $usuario) {
            if (!$usuario->hasRole($role->name)) {
                array_push($users, $usuario);
            }
        }

        return view('paginas.grupos.addusuariogrupo', compact('users', 'role'));
    }

    // ADICIONA OS USUÁRIOS AO GRUPO DE ACESSO SELEDIONADO
    public function adicionaUsuarioGrupo(Request $request, $id)
    {

        $role = Role::find($id);

        try {
            DB::beginTransaction();
            foreach ($request->users as $user) {
                $u = User::find($user);
                $u->assignRole($role->name);
            }
            DB::commit();
            return redirect()->route('roles.index')->with('toast_success', 'Usuáio(s) adicionados com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('roles.index')->with('toast_error', 'Ops! Erro ao adiciona usuário do grupo !');
        }
    }

    // CARREGA A VIEW QUE REMOVE USUARIOS DE UM GRUPO
    public function viewRemoveUsuarioGrupo($id)
    {
        $role = Role::find($id);

        $usuarios = $role->users;
        $users = [];
        foreach ($usuarios as $usuario) {
            if ($usuario->hasRole($role->name)) {
                array_push($users, $usuario);
            }
        }

        return view('paginas.grupos.remusuariogrupo', compact('users', 'role'));
    }


    // REMOVE O USUÁRIO DO GRUPO
    public function removeUsuarioGrupo(Request $request, $id)
    {
        $role = Role::find($id);

        try {
            DB::beginTransaction();
            foreach ($request->users as $user) {
                $u = User::find($user);
                $u->removeRole($role->name);
            }
            DB::commit();
            return redirect()->route('roles.index')->with('toast_success', 'Usuário(s) excluídos com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('roles.index')->with('toast_error', 'Ops! Erro ao remover usuário do grupo !');
        }
    }

}
