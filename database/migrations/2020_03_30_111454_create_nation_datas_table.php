<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNationDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nation_datas', function (Blueprint $table) {
            $table->date('dateRep');
            $table->integer('day');
            $table->integer('month');
            $table->integer('year');
            $table->integer('cases');
            $table->integer('deaths');
            $table->string('countriesAndTerritories');
            $table->string('geoId');
            $table->string('countryterritoryCode');
            $table->integer('popData2018');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nation_datas');
    }
}
