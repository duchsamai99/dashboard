<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteDescription extends Model
{
    protected $table = 'tbl_site_descriptions';
    public $primaryKey = 'sitAutoID';
    public $timestamps = false; 
}
