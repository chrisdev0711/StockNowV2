<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->string('phoneNumber')->after('email')->nullable(true);
            $table->string('merchantId')->after('phoneNumber')->nullable(true);
            $table->string('logoUrl')->after('merchantId')->nullable(true);
            $table->boolean('status')->default(1)->after('logoUrl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn('phoneNumber');
            $table->dropColumn('merchantId');
            $table->dropColumn('logoUrl');
            $table->dropColumn('status');
        });
    }
}
