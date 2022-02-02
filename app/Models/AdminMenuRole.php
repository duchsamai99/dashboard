<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminMenuRole extends Model
{
    protected $table = 'tbl_admin_menu_roles';
    public $primaryKey = 'amrAutoID';
    public $timestamps = false; 
}
