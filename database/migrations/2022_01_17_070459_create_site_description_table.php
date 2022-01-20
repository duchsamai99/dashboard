<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteDescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_description', function (Blueprint $table) {
            $table->bigIncrements('SitId');
            $table->string('SitImage1')->nullable();
            $table->string('SitImage2')->nullable();
            $table->string('SitImage3')->nullable();
            $table->string('SitName');
            $table->string('SitCopyRight');
            $table->string('SitReceiverMail');
            $table->string('SitPhoneNumber');
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
        Schema::dropIfExists('site_description');
    }
}
