<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('updated_user_id')->default(0);
            $table->unsignedBigInteger('deactivate_user_id')->default(0);
            $table->unsignedBigInteger('client_id');
            $table->decimal('valor', 10, 2)->nullable(true);
            $table->string('pagamento');
            $table->string('prazo');
            $table->string('transportadora');
            $table->text('observacoes');
            /*$table->integer('quantidade', 5);
            $table->decimal('icms', 10, 2)->nullable(true);
            $table->decimal('ipi', 10, 2)->nullable(true);*/
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotes');
    }
}
