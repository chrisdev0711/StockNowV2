<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationIdsToSellablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sellables', function (Blueprint $table) {
            $table->string('presentLocationIds')->nullable(true)->after('total_sale');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sellables', function (Blueprint $table) {
            $table->dropColumn('presentLocationIds');
        });
    }
}
