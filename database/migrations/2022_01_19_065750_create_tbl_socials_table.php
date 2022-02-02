<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_socials', function (Blueprint $table) {
            $table->bigIncrements('socAutoID');
            $table->integer('socID')->unsigned();
            $table->string('socLang');
            $table->string('socTitle');
            $table->string('socImage')->nullable();;
            $table->string('socFollower');
            $table->string('socSign');
            $table->string('socDescription')->nullable();
            $table->integer('socOrder');
            $table->integer('socStatus')->default(0);
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
        Schema::dropIfExists('tbl_socials');
    }
}
