<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use DB;
use Hash;
use DataTables;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Requests\Admin\UsuarioStoreRequest;
use App\Http\Requests\Admin\UsuarioUpdateRequest;



class UsuarioController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth')->except('login');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('paginas.usuarios.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('paginas.usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsuarioStoreRequest $request)
    {
        try {

            DB::beginTransaction();
            $user = new User();
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = Hash::make($request->get('password'));
            $user->remember_token = Hash::make($request->get('email'));
            $user->email_verified_at = now();
            $user->save();

            DB::commit();

            return redirect()->route('users.index')->with('toast_success', 'Usuario cadastrado com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('users.index')->with('toast_error', 'Ops! Usuario não cadastrada !');
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
        $user = User::find($id);
        return view('paginas.usuarios.edit',['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsuarioUpdateRequest $request, $id)
    {
        try {

            DB::beginTransaction();
            $user = User::find($id);

            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->status = $request->get('status');

            $user->save();

            DB::commit();

            return redirect()->route('users.index')->with('toast_success', 'Usuario alterado com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('users.index')->with('toast_error', 'Ops! Usuario não alterado !');
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

    // RETORNA A INDEX DOS REGISTROS DOS USUARIOS
    public function indexDatatable(){
        $users = User::select([
            'id', 'name', 'status','email'
        ]);

        return Datatables::of($users)
            ->addColumn('btnedit',   'paginas.usuarios.actionedit')
            ->addColumn('btnlibper', 'paginas.usuarios.actionlibper')
            ->addColumn('btnbloper', 'paginas.usuarios.actionbloper')
            ->rawColumns(['btnedit','btnlibper','btnbloper'])
            ->toJson();
    }

    // CARREGA A VIEW COM AS PERMISSÕES QUE O USUÁRIO NÃO TEM ACESSO LIBERADO PARA SEREM LIBERADAS
    public function viewAdicionaPermissaoUsuario($id)
    {

        $user = User::find($id);
        $opcoes = Permission::orderBy('name', 'asc')->get();
        $permissions = [];
        foreach ($opcoes as $opcao) {
            if (!$user->hasPermissionTo($opcao)) {
                array_push($permissions, $opcao);
            }
        }
        return view('paginas.usuarios.addpermissaousuario', compact('user', 'permissions'));
    }


    // SALVA AS PERMISSÕES QUE O USUÁRIO NÃO TEM ACESSO LIBERADO
    public function adicionaPermissaoUsuario(Request $request, $id)
    {

        $user = User::find($id);

        try {
            DB::beginTransaction();
            foreach ($request->permissions as $permission) {
                $user->givePermissionTo($permission);
            }
            DB::commit();
            return redirect()->route('users.index')->with('toast_success', 'Acesso(s) adicionados com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('users.index')->with('toast_error', 'Ops! Erro ao adicionar acessos do grupo !');
        }
    }

    // CARREGA A VIEW COMAS PERMISSÕES QUE O USUÁRIO TEM LIBERADAS PARA EFETUAR BLOQUEIO
    public function viewRemovePermissaoUsuario($id)
    {
        $user = User::find($id);
        $opcoes = Permission::orderBy('name', 'asc')->get();
        $permissions = [];
        foreach ($opcoes as $opcao) {
            if ($user->hasPermissionTo($opcao)) {
                array_push($permissions, $opcao);
            }
        }
        return view('paginas.usuarios.rempermissaousuario', compact('user', 'permissions'));
    }

    public function removePermissaoUsuario(Request $request, $id)
    {
        $user = User::find($id);

        try {
            DB::beginTransaction();
            foreach ($request->permissions as $permission) {
                $user->revokePermissionTo($permission);
            }
            DB::commit();
            return redirect()->route('users.index')->with('toast_success', 'Acesso(s) removidos com sucesso !');
        } catch (exception $e) {
            DB::rollback();
            return redirect()->route('users.index')->with('toast_error', 'Ops! Erro ao remover acessos do grupo !');
        }
    }


    // APRESENTA A VIEW DE LOGIN
    public function loginView()
    {
        return view('paginas.usuarios.login');
    }


    // EFETUA O LOGIN
    public function login(Request $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
            if (Auth::user()->status == 'Ativo') {
                return redirect()->route('home');
            } else {
                return view('paginas.usuarios.login');
            }
        } else {
            return view('paginas.usuarios.login');
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function viewAlterarSenha()
    {
        return view('paginas.usuarios.alterasenha');
    }

    public function updateSenha(Request $request)
    {
        $request->validate([
            'nova' => ['required', 'min:6'],
            'confirma' => ['required', 'same:nova'],
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            return redirect()->route('alterar.senha')->with('toast_warning', 'Ops! Senha atual não confere com a informada !');
        } else {
            User::find(auth()->user()->id)->update(['password' => Hash::make($request->nova)]);
            return redirect()->route('alterar.senha')->with('toast_success', 'Senha alterada com sucesso !');
        }
    }

}
