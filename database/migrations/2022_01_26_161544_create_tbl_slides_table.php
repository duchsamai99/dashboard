<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_slides', function (Blueprint $table) {
            $table->bigIncrements('sliAutoID');
            $table->integer('sliID')->unsigned();
            $table->string('sliLang');
            $table->string('sliName');
            $table->string('sliImage')->nullable();
            $table->string('sliLink');
            $table->integer('sliOrder');
            $table->integer('sliStatus');
            $table->longText('sliDescription')->nullable();;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_slides');
    }
}
