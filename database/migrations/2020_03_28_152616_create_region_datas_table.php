<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('region_datas', function (Blueprint $table) {
            $table->dateTimeTz('data');
            $table->string('stato');
            $table->integer('codice_regione');
            $table->string('denominazione_regione');
            $table->integer('codice_provincia');
            $table->string('denominazione_provincia');
            $table->string('sigla_provincia');
            $table->double('lat');
            $table->double('long');
            $table->integer('totale_casi');
            $table->string('note_it');
            $table->string('note_en');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('region_datas');
    }
}
