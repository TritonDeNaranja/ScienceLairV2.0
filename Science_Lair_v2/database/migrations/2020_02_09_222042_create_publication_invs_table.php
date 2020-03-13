<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicationInvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publication_invs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title_inv');
            $table->string('nameinv');
            $table->timestamps();

            $table->foreign('title_inv')->references('title')->on('publications')->onUpdate('Cascade')->onDelete('Cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publication_invs');
    }
}
