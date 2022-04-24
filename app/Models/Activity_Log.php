<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity_Log extends Model
{
    protected $table = 'tblactivity_log';
    protected $fillable = ['description','date','staffid'];
    public $timestamps = false;


}
