<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->timestamp('transaction_time');
            $table->string('location_id');
            $table->string('catalog_object_id');
            $table->decimal('quantity');
            $table->string('name');
            $table->string('sub_name');
            $table->decimal('gross_sale_money');
            $table->decimal('total_tax_money');
            $table->string('currency');
            $table->decimal('net_sale_money');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
