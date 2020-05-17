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
            $table->string('province_state');
            $table->string('country_region');
            $table->double('latitude');
            $table->double('longitude');
            $table->dateTime('last_update');
            $table->integer('confirmed');
            $table->integer('deaths');
            $table->integer('recovered');
            
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