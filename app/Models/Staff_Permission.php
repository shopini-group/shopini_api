<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff_Permission extends Model
{
    protected $table = 'tblstaff_permissions';
    protected $fillable = ['staff_id','feature','capability'];

}
