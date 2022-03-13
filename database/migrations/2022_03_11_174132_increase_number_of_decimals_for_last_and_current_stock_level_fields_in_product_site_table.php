<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncreaseNumberOfDecimalsForLastAndCurrentStockLevelFieldsInProductSiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_site', function (Blueprint $table) {
            $table->decimal('last_stock_level', 10, 8)->default(0)->change();
            $table->decimal('current_stock_level', 10, 8)->default(0)->change(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_site', function (Blueprint $table) {
            //
        });
    }
}
