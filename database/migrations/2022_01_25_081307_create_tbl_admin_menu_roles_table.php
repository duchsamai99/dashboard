<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblAdminMenuRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_admin_menu_roles', function (Blueprint $table) {
            $table->bigIncrements('amrAutoID');
            $table->integer('amrRoleID')->unsigned();
            $table->string('amrRoleName');
            $table->integer('amrMenusID')->unsigned();
            $table->integer('amrView')->default(0);
            $table->integer('amrInsert')->default(0);
            $table->integer('amrDelete')->default(0);
            $table->integer('amrUpdate')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_admin_menu_roles');
    }
}
