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
            $table->double('lat');
            $table->double('long');
            $table->integer('ricoverati_con_sintomi');
            $table->integer('terapia_intensiva');
            $table->integer('totale_ospedalizzati');
            $table->integer('isolamento_domiciliare');
            $table->integer('totale_attualmente_positivi');
            $table->integer('variazione_totale_positivi');
            $table->integer('nuovi_attualmente_positivi');
            $table->integer('dimessi_guariti');
            $table->integer('deceduti');
            $table->integer('casi_da_sospetto_diagnostico');
            $table->integer('casi_da_sospetto_screening');
            $table->integer('totale_casi');
            $table->integer('tamponi');
            $table->integer('casi_testati');
            $table->string('note');
            $table->integer('ingressi_terapia_intensiva');
            $table->string('note_test');
            $table->string('note_casi');
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
