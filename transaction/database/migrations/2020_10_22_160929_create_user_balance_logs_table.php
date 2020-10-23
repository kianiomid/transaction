<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBalanceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_user_balance_logs', function (Blueprint $table) {
            $table->bigInteger('id', true);

            $table->bigInteger('user_id')
                ->index();
            $table->foreign('user_id', 'user_id_to_user_balance_log')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->bigInteger('currency_id')->index();
            $table->foreign('currency_id')
                ->references('id')->on('tr_currencies', 'currency_id_to_user_balance_log')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->float('deposit')->nullable();
            $table->float('payment')->nullable();
            $table->string('payment_info1')->nullable();
            $table->string('payment_info2')->nullable();
            $table->string('reason_info1')->nullable();
            $table->string('reason_info2')->nullable();

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
        Schema::dropIfExists('tr_user_balance_logs');
    }
}
