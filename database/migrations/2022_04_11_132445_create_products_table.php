<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('updated_user_id')->default(0);
            $table->unsignedBigInteger('deactivate_user_id')->default(0);
            $table->string('descricao');
            $table->string('codigo', 10)->nullable(true);
            $table->string('espessura', 10)->nullable(true);
            $table->string('cobre', 10)->nullable(true);
            $table->string('arco', 10)->nullable(true);
            $table->decimal('valor', 10, 2)->nullable(true);
            $table->decimal('icms', 10, 2)->nullable(true);
            $table->decimal('ipi', 10, 2)->nullable(true);
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
        Schema::dropIfExists('products');
    }
}
