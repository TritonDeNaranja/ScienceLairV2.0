<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectInvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project__invs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('namepro');
            $table->string('name_inv');
            $table->timestamps();


            $table->foreign('namepro')->references('name_project')->on('projects')->onUpdate('Cascade')->onDelete('Cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project__invs');
    }
}
