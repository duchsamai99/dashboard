<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteMenu extends Model
{
    protected $table = 'tbl_site_menus';
    public $primaryKey = 'smeAutoID';
    public $timestamps = false; 
}
