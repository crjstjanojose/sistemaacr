<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncomendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encomendas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_criacao');
            $table->unsignedBigInteger('user_confirmacao')->nullable();
            $table->unsignedBigInteger('user_solicitacao')->nullable();
            $table->unsignedBigInteger('user_exclusao')->nullable();
            $table->unsignedBigInteger('user_alteracao')->nullable();
            $table->unsignedBigInteger('produto_id');
            $table->unsignedBigInteger('caracteristica_id');
            $table->string('nome');
            $table->string('contato')->nullable();
            $table->tinyInteger('quantidade');
            $table->decimal('preco', 8, 2);
            $table->date('previsao');
            $table->timestamp('entrega')->nullable();
            $table->enum('situacao_pedido', ['Pendente', 'Solicitado', 'Cancelada', 'Entregue'])->default('Pendente');
            $table->enum('tipo_encomenda', ['Falta', 'Baixo', 'Procura', 'Encomenda']);

            $table->foreign('user_criacao', 'fk_user_criacao')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('user_confirmacao', 'fk_user_confirmacao')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('user_solicitacao', 'fk_user_solicitacao')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('user_exclusao', 'fk_user_exclusao')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('user_alteracao', 'fk_user_alteracao')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('produto_id', 'fk_produto')
                ->references('id')
                ->on('produtos')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('caracteristica_id', 'fk_caracteristica')
                ->references('id')
                ->on('caracteristicas')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encomendas');
    }
}
