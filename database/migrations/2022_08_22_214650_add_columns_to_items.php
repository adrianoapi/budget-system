<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->decimal('fator', 10, 2)->default(0);
            $table->enum('icms', ['inclusivo', '4','12','18'])->default('inclusivo');
            $table->enum('ipi',  ['inclusivo', 'isento','7.5'])->default('inclusivo');
            $table->decimal('valor', 10, 2)->nullable(true);
            $table->integer('ordem')->default(0);
        });
    } 

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('fator');
            $table->dropColumn('icms');
            $table->dropColumn('ipi');
            $table->dropColumn('valor');
            $table->dropColumn('ordem');
        });
    }
}
