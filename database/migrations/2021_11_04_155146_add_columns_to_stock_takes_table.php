<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToStockTakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_takes', function (Blueprint $table) {
            $table->string('sub_type')->after('type')->nullable(true);
            $table->string('area_name')->after('area')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_takes', function (Blueprint $table) {
            $table->dropColumn('sub_type');
            $table->dropColumn('area_name');
        });
    }
}
