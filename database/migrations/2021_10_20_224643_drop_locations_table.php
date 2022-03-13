<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('locations');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('name');
            $table->string('address');
            $table->string('locality');
            $table->string('postalCode');
            $table->boolean('status')->default(1);
            $table->string('country');
            $table->string('languageCode');
            $table->string('merchantId');
            $table->string('currency');
            $table->string('phoneNumber');
            $table->string('businessName');
            $table->string('logoUrl');
            $table->timestamps();
        });
    }
}
