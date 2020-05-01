<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cidade_id');
            $table->unsignedBigInteger('user_criacao');
            $table->unsignedBigInteger('user_alteracao')->nullable();
            $table->string('nome',150);
            $table->integer('idade');
            $table->string('endereco',150);
            $table->string('bairro',150);
            $table->string('celular',10);
            $table->string('telefone',10);
            $table->string('rg',20);
            $table->string('cpf',20);

            $table->foreign('cidade_id', 'fk_cidade')
                ->references('id')
                ->on('cidades')
                ->onDelete('restrict')
                ->onUpdate('restrict');


            $table->foreign('user_criacao', 'fk_user_criacao_cliente')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');


            $table->foreign('user_alteracao', 'fk_user_alteracao_cliente')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
