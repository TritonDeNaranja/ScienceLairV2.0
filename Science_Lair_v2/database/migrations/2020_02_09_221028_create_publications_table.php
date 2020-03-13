<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->string('title')->unique();
            $table->string('title2')->nullable();
            $table->string('revact');
            $table->string('date');
            $table->enum('pubtype', ['INDEXADA','NO INDEXADA'])->default('INDEXADA');
            $table->string('subpubtype');
            $table->string('proy');
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
        Schema::dropIfExists('publications');
    }
}
