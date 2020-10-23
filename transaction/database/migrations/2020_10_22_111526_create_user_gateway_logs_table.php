<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGatewayLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_user_gateway_logs', function (Blueprint $table) {
            $table->bigInteger('id', true);

            $table->bigInteger('user_id')
                ->index();
            $table->foreign('user_id', 'user_id_to_user_gateway_logs')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->bigInteger('currency_id')->index()->nullable();
            $table->foreign('currency_id')
                ->references('id')->on('tr_currencies', 'currency_id_to_user_gateway_logs')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->float('price')->default(null);
            $table->string('gateway_result')->default(null);

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
        Schema::dropIfExists('tr_user_gateway_logs');
    }
}
