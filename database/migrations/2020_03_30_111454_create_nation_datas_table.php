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
            $table->integer('fips');
            $table->string('admin2');
            $table->string('province_state');
            $table->string('country_region');
            $table->dateTime('last_update');
            $table->double('latitude');
            $table->double('longitude');
            $table->integer('confirmed');
            $table->integer('deaths');
            $table->integer('recovered');
            $table->integer('active');
            $table->string('combined_key');
            
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
