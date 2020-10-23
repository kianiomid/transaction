<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusCodeToTrUserGatewayLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tr_user_gateway_logs', function (Blueprint $table) {
            $table->string('status_code')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tr_user_gateway_logs', function (Blueprint $table) {
            $table->dropColumn('status_code');
        });
    }
}
