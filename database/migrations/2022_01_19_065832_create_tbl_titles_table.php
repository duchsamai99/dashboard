<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_titles', function (Blueprint $table) {
            $table->bigIncrements('titAutoID');
            $table->integer('titID')->unsigned();
            $table->string('titLang');
            $table->string('titTitle');
            $table->string('titAlias');
            $table->string('titDescription');
            $table->integer('titStatus')->default(0);
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
        Schema::dropIfExists('tbl_titles');
    }
}
