<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAplicacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aplicacoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('produto_id');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('user_criacao');
            $table->unsignedBigInteger('user_aplicacao');
            $table->unsignedBigInteger('user_alteracao')->nullable();
            $table->integer('documento_fiscal');
            $table->date('data_venda');
            $table->date('data_aplicacao');
            $table->text('observacao')->nullable();

            $table->foreign('cliente_id', 'fk_cliente_apl')
                ->references('id')
                ->on('clientes')
                ->onDelete('restrict')
                ->onUpdate('restrict');


            $table->foreign('produto_id', 'fk_produto_apl')
                ->references('id')
                ->on('produtos')
                ->onDelete('restrict')
                ->onUpdate('restrict');


            $table->foreign('user_criacao', 'fk_user_criacao_apl')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('user_alteracao', 'fk_user_alteracao_apl')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('user_aplicacao', 'fk_user_aplicacao_apl')
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
        Schema::dropIfExists('aplicacoes');
    }
}
