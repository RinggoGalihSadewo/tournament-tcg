<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament', function (Blueprint $table) {
            $table->id('id_tournament');
            $table->string('name_tournament');
            $table->dateTime('date_tournament');
            $table->string('description_tournament');
            $table->string('photo_tournament');
            $table->string('status_tournament');
            $table->timestamps();
            
            $table->foreignId('id_tcg')->references('id_tcg')->on('tcg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tournament');
    }
}
