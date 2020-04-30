<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo',200);
            $table->text('descricao');
            $table->unsignedBigInteger('user_criacao');
            $table->unsignedBigInteger('user_compra')->nullable();
            $table->unsignedBigInteger('user_cancela')->nullable();
            $table->unsignedBigInteger('user_entrega')->nullable();
            $table->enum('situacao', ['Pendente', 'Atendida', 'Cancelada'])->default('Pendente');

            $table->foreign('user_criacao', 'fk_user_criacao_mat')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('user_compra', 'fk_user_compra_mat')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('user_cancela', 'fk_user_cancela_mat')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('user_entrega', 'fk_user_entrega_mat')
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
        Schema::dropIfExists('materiais');
    }
}
