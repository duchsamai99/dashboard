<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = 'tbl_actions';
    public $primaryKey = 'actAutoID';
    public $timestamps = false; 
}
