<?php

namespace App\Models;

use App\Models\Departments\Department;
use App\Models\Employees\Employee;
use Illuminate\Database\Eloquent\Model;

class EmployeeDepartment extends Model
{
    protected $table = 'employees_departments';

    //
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
