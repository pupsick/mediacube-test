<?php

namespace App\Http\Controllers;

use App\Models\Departments\Department;
use App\Models\Employees\Employee;
use Illuminate\Http\Request;

class CoreController extends Controller
{
    public function fetchData(Request $request)
    {
        $fetchArray = config('routes.fetchData');
        $method = '';
        if (array_key_exists($request->path, $fetchArray)) {
            $method = $fetchArray[$request->path];
        }
        if ($method != '') {
            $params = $request->additional;
            return app()->call($method, [$params]);
        } else {
            return [];
        }
    }

    public function loadEmployees($page = 1)
    {
        $employees = Employee::with("departments.department")->paginate(10, ["*"], "page", $page);
        foreach ($employees as &$employee) {
            $employee->departments_id = $employee->departments->pluck("department.id")->toArray();
        }
        return $employees;
    }

    public function mainPageData()
    {

        $departments = Department::all();
        return [
            'employees' => $this->loadEmployees(),
            'departments' => $departments
        ];
    }
}
