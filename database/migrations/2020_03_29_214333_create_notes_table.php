<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->string('codice');
            $table->dateTimeTz('data');
            $table->string('dataset');
            $table->string('stato');
            $table->integer('codice_regione');
            $table->string('regione');
            $table->integer('codice_provincia');
            $table->string('provincia');
            $table->string('sigla_provincia');
            $table->string('tipologia_avviso');
            $table->string('avviso');
            $table->string('note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
