<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_units', function (Blueprint $table) {

            $table->string('namegroup');
            $table->string('unit');
            $table->string('country');
            $table->timestamps();

            $table->foreign('namegroup')->references('name')->on('groups')->onUpdate('Cascade')->onDelete('Cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country_units');
    }
}
