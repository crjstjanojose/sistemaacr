<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cidades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_criacao');
            $table->unsignedBigInteger('user_alteracao')->nullable();
            $table->unsignedBigInteger('estado_id');
            $table->string('descricao',100);


            $table->foreign('user_criacao', 'fk_user_criacao_cidade')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');


            $table->foreign('user_alteracao', 'fk_user_alteracao_cidade')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');


            $table->foreign('estado_id', 'fk_estado')
                ->references('id')
                ->on('estados')
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
        Schema::dropIfExists('cidades');
    }
}
