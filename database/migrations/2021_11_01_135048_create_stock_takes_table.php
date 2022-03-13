<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTakesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_takes', function (Blueprint $table) {
            $table->id();

            $table->datetime('started_on');
            $table->unsignedBigInteger('started_by_id')->nullable();
            $table->enum('area', ['All Areas', 'By Area'])->default('All Areas');
            $table->enum('type', ['Full Stocktake', 'By Category', 'By Supplier'])->default('Full Stocktake');
            $table->boolean('completed')->nullable();
            $table->boolean('approved')->nullable();
            $table->unsignedBigInteger('location')->nullable();

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
        Schema::dropIfExists('stock_takes');
    }
}
