<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('updated_user_id')->default(0);
            $table->unsignedBigInteger('deactivate_user_id')->default(0);
            $table->string('name', 100)->nullable(true);
            $table->string('responsavel', 100)->nullable(true);
            $table->string('cpf_cnpj', 30)->nullable(true);
            $table->string('ie', 30)->nullable(true);
            $table->string('telefone', 20)->nullable(true);
            $table->string('telefone_com', 20)->nullable(true);
            $table->string('celular', 20)->nullable(true);
            $table->string('email')->nullable(true);
            $table->string('cep', 9)->nullable(true);
            $table->string('endereco')->nullable(true);
            $table->integer('numero')->nullable(true);
            $table->string('complemento', 20)->nullable(true);
            $table->string('bairro')->nullable(true);
            $table->string('cidade')->nullable(true);
            $table->string('estado', 2)->nullable(true);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
