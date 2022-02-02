<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $table = 'tbl_slides';
    public $primaryKey = 'sliAutoID';
    public $timestamps = false;  
}
