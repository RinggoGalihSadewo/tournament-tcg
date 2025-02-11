<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDecklogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('decklog', function (Blueprint $table) {
            $table->id('id_decklog');
            $table->string('username');
            $table->string('photo');
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
        Schema::dropIfExists('decklog');
    }
}
