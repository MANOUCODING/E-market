<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('nomClasse');
            $table->string('codeClasse');
            $table->string('cycle');
            $table->string('section');
            $table->boolean('finDeCycle')->default(0);
            $table->integer('effectifTotal')->default(0);
            $table->integer('capacite');
            $table->string('classeSuperieure')->nullable();
            $table->boolean('sousClasses')->default(0);
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
        Schema::dropIfExists('classes');
    }
}
