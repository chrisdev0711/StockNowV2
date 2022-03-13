<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSellablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sellables', function (Blueprint $table) {
            $table->string('uuid')->nullable()->after('active');
            $table->string('parent_id')->nullable()->after('uuid');
            $table->enum('variant', ['standard', 'parent', 'child'])->default('standard')->after('parent_id');
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
            $table->dropColumn('uuid');
            $table->dropColumn('parent_id');
            $table->dropColumn('variant');
        });
    }
}
