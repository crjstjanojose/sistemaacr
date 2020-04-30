<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_criacao');
            $table->unsignedBigInteger('user_alteracao')->nullable();
            $table->string('sigla',2)->unique();
            $table->string('descricao',100)->unique();


            $table->foreign('user_criacao', 'fk_user_criacao_estado')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');


            $table->foreign('user_alteracao', 'fk_user_alteracao_estado')
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
        Schema::dropIfExists('estados');
    }
}
