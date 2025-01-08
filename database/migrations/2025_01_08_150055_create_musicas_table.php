<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musicas', function (Blueprint $table) {
            $table->id(); 
            $table->string('titulo'); 
            $table->integer('visualizacoes')->default(0); 
            $table->string('youtube_id')->unique(); 
            $table->string('thumb')->nullable(); 
            $table->string('url')->nullable(); 
            $table->enum('status', ['Aprovado', 'Reprovado', 'Pendente'])->default('Pendente'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('musicas');
    }
}
