<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('name');
            $table->string('sku')->nullable();
            $table->text('description')->nullable();
            $table->decimal('par_level')->nullable();
            $table->decimal('reorder_point')->nullable();
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->string('supplier_sku')->nullable();
            $table->decimal('entered_cost')->nullable();
            $table->boolean('entered_inc_vat')->nullable();
            $table->decimal('vat_rate')->nullable();
            $table->decimal('gross_cost')->nullable();
            $table->decimal('net_cost')->nullable();
            $table->string('pack_type')->nullable();
            $table->boolean('multipack')->nullable();
            $table->decimal('units_per_pack')->nullable();
            $table->decimal('servings_per_unit')->nullable();

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
        Schema::dropIfExists('products');
    }
}
