<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSiteMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_site_menus', function (Blueprint $table) {
            $table->bigIncrements('smeAutoID');
            $table->integer('smeID')->unsigned();
            $table->integer('sme_smeAutoID')->nullable();
            $table->string('smeLang');
            $table->string('smeName');
            $table->string('smePageName');
            $table->integer('smeOrder');
            $table->integer('sequence');
            $table->integer('smeStatus')->default(0);
            $table->string('smeHref')->nullable();
            $table->string('smeIcon')->nullable();
            $table->string('smeSlug');
            $table->integer('smeParent_id')->unsigned()->nullable();
            $table->integer('smeMenu_id')->unsigned();
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
        Schema::dropIfExists('tbl_site_menus');
    }
}
