<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    protected $table = 'tbl_titles';
    public $primaryKey = 'titAutoID';
    public $timestamps = false; 
}
