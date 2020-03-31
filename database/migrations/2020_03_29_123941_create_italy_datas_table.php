<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItalyDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('italy_datas', function (Blueprint $table) {
            $table->dateTimeTz('data');
            $table->string('stato');
            $table->integer('ricoverati_con_sintomi');
            $table->integer('terapia_intensiva');
            $table->integer('totale_ospedalizzati');
            $table->integer('isolamento_domiciliare');
            $table->integer('totale_attualmente_positivi');
            $table->integer('variazione_totale_positivi');
            $table->integer('nuovi_attualmente_positivi');
            $table->integer('dimessi_guariti');
            $table->integer('deceduti');
            $table->integer('totale_casi');
            $table->integer('tamponi');
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
        Schema::dropIfExists('italy_datas');
    }
}
