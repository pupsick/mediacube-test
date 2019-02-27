<?php

namespace App\Http\Controllers\Departments;

use App\Models\Departments\Department;
use App\Models\EmployeeDepartment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function show(Request $request)
    {
        $departments = Department::withCount('employees')->get();
        $ids = $departments->pluck("id");
        $max_salaries = DB::table('employees_departments AS ed')
            ->select('ed.department_id', DB::raw('max(e.salary) as max_salary'))
            ->join('employees as e', 'e.id', '=', 'ed.employee_id')
            ->whereIn('ed.department_id', $ids)
            ->groupBy('ed.department_id')
            ->get();
        foreach ($departments as &$department) {
            $department->max_salary = optional($max_salaries->where('department_id',
                    $department->id)->first())->max_salary ?? 0;
        }
        return $departments;
    }

    public function edit(Request $request)
    {
        $department = Department::find($request->additional['id']);
        if (!$department) {
            return ['redirect' => '/departments'];
        } else {
            return $department;
        }
    }

    public function editAction(Request $request)
    {
        if (!$request->has("name") || strlen($request->name) <= 3) {
            return [
                'error' => true,
                'msg' => 'Слишком короткое название'
            ];
        }

        $department = Department::find($request->id);
        if (!$department) {
            return [
                'error' => true,
                'msg' => 'Указанного отдела не найдено'
            ];
        }

        $department->name = $request->name;
        $department->save();

        return [
            'error' => false,
            'msg' => 'Название обновлено'
        ];
    }

    public function delete(Request $request)
    {
        $department = Department::find($request->id);
        if (!$department) {
            return [
                'error' => true,
                'msg' => 'Указанного отдела не найдено'
            ];
        }

        if (EmployeeDepartment::where("department_id", $department->id)->exists()) {
            return [
                'error' => true,
                'msg' => 'Невозможно удалить отдел, пока там есть хотя бы один работник'
            ];
        }

        $department->delete();

        return [
            'error' => false,
            'msg' => "Отдел успешно удален",
            'redirect' => '/departments'
        ];
    }

    public function addAction(Request $request)
    {
        if (!$request->has("name") || strlen($request->name) <= 1) {
            return [
                'error' => true,
                'msg' => 'Слишком короткое название'
            ];
        }

        $department = new Department();
        $department->name = $request->name;
        $department->save();

        return [
            'error' => false,
            'msg' => 'Отдел успешно добавлен',
            'redirect' => "/departments/{$department->id}"
        ];
    }
}
