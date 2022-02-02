<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblMenuRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_menu_roles', function (Blueprint $table) {
            $table->bigIncrements('merAutoID');
            $table->integer('merRoleID')->unsigned();
            $table->string('merRoleName');
            $table->integer('merMenusID')->unsigned();
            $table->integer('merView')->default(0);
            $table->integer('merInsert')->default(0);
            $table->integer('merDelete')->default(0);
            $table->integer('merUpdate')->default(0);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_menu_roles');
    }
}
