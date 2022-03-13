<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToSellablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sellables', function (Blueprint $table) {
            $table->decimal('price')->default(0)->after('description');
            $table->decimal('cost')->default(0)->after('price');
            $table->decimal('total_sale')->default(0)->after('cost');
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
            $table->dropColumn('price');
            $table->dropColumn('cost');
            $table->dropColumn('total_sale');
        });
    }
}
