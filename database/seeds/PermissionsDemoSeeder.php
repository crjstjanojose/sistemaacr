<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\User;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // Reset cached roles and permissions
       app()[PermissionRegistrar::class]->forgetCachedPermissions();


       // CONTROLE DE ACESSO
       Permission::create(['name' => 'controle-acesso-configuracoes']);

       // USUARIOS
       Permission::create(['name' => 'usuario-listar']);
       Permission::create(['name' => 'usuario-criar']);
       Permission::create(['name' => 'usuario-editar']);
       Permission::create(['name' => 'usuario-atribuir-permissao']);
       Permission::create(['name' => 'usuario-remover-permissao']);

       // PERMISSOES
       Permission::create(['name' => 'permissao-criar']);
       Permission::create(['name' => 'permissao-listar']);
       Permission::create(['name' => 'permissao-editar']);

       // GRUPOS
       Permission::create(['name' => 'grupos-listar']);
       Permission::create(['name' => 'grupos-criar']);
       Permission::create(['name' => 'grupos-editar']);
       Permission::create(['name' => 'grupos-atribuir-permissao']);
       Permission::create(['name' => 'grupos-remover-permissao']);
       Permission::create(['name' => 'grupos-atribuir-usuario']);
       Permission::create(['name' => 'grupos-remover-usuario']);

       // PRODUTOS
       Permission::create(['name' => 'produtos-listar']);
       Permission::create(['name' => 'produtos-importar']);
       Permission::create(['name' => 'produtos-editar']);

       // ENCOMENDAS
       Permission::create(['name' => 'encomendas-listar-pendentes']);
       Permission::create(['name' => 'encomendas-listar-solicitadas']);
       Permission::create(['name' => 'encomendas-listar-entregues']);
       Permission::create(['name' => 'encomendas-criar']);
       Permission::create(['name' => 'encomendas-editar']);
       Permission::create(['name' => 'encomendas-excluir']);
       Permission::create(['name' => 'encomendas-comprar']);
       Permission::create(['name' => 'encomendas-cancelar-compra']);
       Permission::create(['name' => 'encomendas-entregar']);
       Permission::create(['name' => 'encomendas-cancelar-entrega']);

       // CARACTERISTICAS
       Permission::create(['name' => 'caracteristica-listar']);
       Permission::create(['name' => 'caracteristica-criar']);
       Permission::create(['name' => 'caracteristica-editar']);
       Permission::create(['name' => 'caracteristica-excluir']);


       // create roles and assign existing permissions
       $role1 = Role::create(['name' => 'admin']);
       $role1->givePermissionTo(Permission::all());


        // create demo users
        $user = DB::table('users')->insert([
            'name' => 'Cristiano Silva',
            'email' => 'crjstjanojose@gmail.com',
            'password' => bcrypt('025365'),
        ]);

        //$user->assignRole($role1);

        //$user->assignRole($role1->id);

    }
}
