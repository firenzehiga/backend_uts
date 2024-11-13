<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = ['name', 'gender', 'phone', 'address', 'email', 'status', 'hired_on'];

}
