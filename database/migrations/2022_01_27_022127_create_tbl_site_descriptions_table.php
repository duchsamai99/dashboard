<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSiteDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_site_descriptions', function (Blueprint $table) {
            $table->bigIncrements('sitAutoID');
            $table->integer('sitID')->unsigned();
            $table->string('sitLang');
            $table->string('sitImage1')->default('amatak_logo.jpg');
            $table->string('sitImage2')->nullable();
            $table->string('sitImage3')->nullable();
            $table->string('sitName');
            $table->string('sitCopyRight');
            $table->string('sitReceiverMail');
            $table->string('sitPhoneNumber');
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
        Schema::dropIfExists('tbl_site_descriptions');
    }
}
