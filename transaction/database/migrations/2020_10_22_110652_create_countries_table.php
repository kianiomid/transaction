<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_countries', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('currency_id')->index();
            $table->foreign('currency_id')
                ->references('id')->on('tr_currencies')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->string('name');
            $table->string('descriptor');
            $table->string('abbreviation');
            $table->string('week_holidays');
            $table->string('default_timezone');
            $table->boolean('enable')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tr_countries');
    }
}
