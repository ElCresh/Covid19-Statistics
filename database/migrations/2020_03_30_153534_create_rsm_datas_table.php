<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRsmDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rsm_datas', function (Blueprint $table) {
            $table->date('data');
            $table->string('link');
            $table->integer('totale_casi');
            $table->integer('totale_casi_frontalieri');
            $table->integer('totale_casi_interni');
            $table->integer('nuovi_casi');
            $table->integer('malati');
            $table->integer('nuovi_malati');
            $table->integer('malati_maschi');
            $table->integer('malati_femmine');
            $table->integer('guariti');
            $table->integer('nuovi_guariti');
            $table->integer('decessi');
            $table->integer('nuovi_decessi');
            $table->integer('decessi_maschi');
            $table->integer('decessi_femmine');
            $table->integer('ricoverati');
            $table->integer('terapia_intensiva');
            $table->integer('terapia_intensiva_maschi');
            $table->integer('terapia_intensiva_femmine');
            $table->integer('degenze_covid');
            $table->integer('degenze_covid_maschi');
            $table->integer('degenze_covid_femmine');
            $table->integer('domicilio');
            $table->integer('domicilio_maschi');
            $table->integer('domicilio_femmine');
            $table->integer('dimissioni');
            $table->integer('nuove_dimissioni');
            $table->integer('tamponi');
            $table->integer('nuovi_tamponi');
            $table->integer('persone_con_tampone');
            $table->integer('rapporto_tamponi_persone');
            $table->integer('tamponi_positivi');
            $table->integer('tamponi_negativi');
            $table->integer('tamponi_in_attesa');
            $table->integer('sierologici');
            $table->integer('nuovi_sierologici');
            $table->integer('quarantene');
            $table->integer('quarantene_attive');
            $table->integer('quarantene_attive_laici');
            $table->integer('quarantene_attive_sanitari');
            $table->integer('quarantene_attive_forze_dell_ordine');
            $table->integer('quarantene_terminate');
            $table->string('media_mobile_3gg_nuovi_casi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rsm_datas');
    }
}
