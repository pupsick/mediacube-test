<?php

namespace App\Models\Departments;

use App\Models\EmployeeDepartment;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    public function employees()
    {
        return $this->hasMany(EmployeeDepartment::class);
    }
}
