<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuRoleSiteMenu extends Model
{
    protected $table = 'tbl_menu_roles';
    public $primaryKey = 'merAutoID';
    public $timestamps = false; 
}
