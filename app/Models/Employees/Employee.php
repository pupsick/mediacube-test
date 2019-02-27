<?php

namespace App\Models\Employees;

use App\Models\EmployeeDepartment;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    public function departments()
    {
        return $this->hasMany(EmployeeDepartment::class);
    }
}
