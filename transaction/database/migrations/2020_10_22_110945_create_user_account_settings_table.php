<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAccountSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_user_account_settings', function (Blueprint $table) {
            $table->bigInteger('id', true);

            $table->bigInteger('user_id')
                ->index();
            $table->foreign('user_id', 'user_id_to_user_account_settings')
                ->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->bigInteger('country_id')
                ->nullable()
                ->index();
            $table->foreign('country_id')
                ->references('id')->on('tr_countries', 'country_id_to_user_account_settings')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->float('account_balance');
            $table->boolean('auto_pay_invoices')->default(false);
            $table->string('default_timezone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_user_account_settings');
    }
}
