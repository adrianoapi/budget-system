<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volumes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_id');
            $table->string('nome', 255)->nullable(true);
            $table->integer('volume')->default(0);
            $table->integer('dimensao_a')->default(0);
            $table->integer('dimensao_b')->default(0);
            $table->integer('dimensao_c')->default(0);

            $table->boolean('edit_dimensao_a')->default(true);
            $table->boolean('edit_dimensao_b')->default(true);
            $table->boolean('edit_dimensao_c')->default(true);

            $table->timestamps();

            $table->foreign('quote_id')->references('id')->on('quotes')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volumes');
    }
}
