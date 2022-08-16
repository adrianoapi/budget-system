<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToQuotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id');
            $table->string('serial', 20)->nullable(true);
            $table->decimal('fator', 1, 1)->nullable(true);
            $table->decimal('total', 10, 2)->nullable(true);
            $table->boolean('close')->default(false);
            
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn('company_id');
            $table->dropColumn('serial');
            $table->dropColumn('fator');
            $table->dropColumn('total');
            $table->dropColumn('close');
        });
    }
}
