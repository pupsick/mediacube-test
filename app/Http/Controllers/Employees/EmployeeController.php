<?php

namespace App\Http\Controllers\Employees;

use App\Models\Employees\Employee;
use App\Models\Departments\Department;
use App\Models\EmployeeDepartment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function add(Request $request)
    {
        return Department::all();
    }

    public function addAction(Request $request)
    {
        if (!$request->has("name") || strlen($request->name) <= 1) {
            return [
                'error' => true,
                'msg' => 'Слишком короткое имя'
            ];
        }

        if (!$request->has("surname") || strlen($request->surname) <= 1) {
            return [
                'error' => true,
                'msg' => 'Слишком короткая фамилия'
            ];
        }

        if (!$request->has("departments") || sizeof($request->departments) == 0) {
            return [
                'error' => true,
                'msg' => 'Необходимо указать хотя бы один отдел для работника'
            ];
        }

        if (!preg_match('/[а-яА-ЯA-Za-z]/', $request->name)
            || !preg_match('/[а-яА-ЯA-Za-z]/', $request->surname)
            || (!preg_match('/[а-яА-ЯA-Za-z]/', $request->patronymic) && strlen($request->patronymic) > 0)) {
            return [
                'error' => true,
                'msg' => 'Имя содержит запрещенные символы'
            ];
        }

        $employee = new Employee();
        $employee->name = $request->name . " " . $request->surname;
        if ($request->patronymic) {
            $employee->name .= " " . $request->patronymic;
        }
        $employee->gender = (int)$request->gender;
        $employee->salary = $request->salary;
        $employee->save();

        $departments = $request->departments;

        $to_insert = [];

        foreach ($departments as $department) {
            $to_insert[] = ['department_id' => $department, 'employee_id' => $employee->id];
        }

        EmployeeDepartment::insert($to_insert);

        return [
            'error' => false,
            'msg' => 'Работник успешно добавлен',
            'redirect' => "/employees/{$employee->id}"
        ];
    }

    public function loadEmployees($page = 1)
    {
        $employees = Employee::with('departments.department')->paginate(10, ["*"], "page", $page);
        foreach ($employees as &$employee) {
            $parts = $employee->departments->pluck("department.name")->toArray();
            $employee->departments_concat = implode(", ", $parts);
            unset($employee->departments);
        }
        return $employees;
    }

    public function show(Request $request)
    {
        return $this->loadEmployees();
    }

    public function edit(Request $request)
    {
        $employee = Employee::with('departments')->find($request->additional['id']);
        if (!$employee) {
            return ['redirect' => '/employees'];
        } else {
            $employee->departments_id = $employee->departments->pluck("department.id")->toArray();
            return [
                'employee' => $employee,
                'departments' => Department::all()
            ];
        }
    }

    public function editAction(Request $request)
    {
        if (!$request->has("name") || strlen($request->name) <= 1) {
            return [
                'error' => true,
                'msg' => 'Слишком короткое имя'
            ];
        }

        if (!$request->has("surname") || strlen($request->surname) <= 1) {
            return [
                'error' => true,
                'msg' => 'Слишком короткая фамилия'
            ];
        }

        if (!$request->has("departments") || sizeof($request->departments) == 0) {
            return [
                'error' => true,
                'msg' => 'Необходимо указать хотя бы один отдел для работника'
            ];
        }


        if (!preg_match('/[а-яА-ЯA-Za-z]/', $request->name)
            || !preg_match('/[а-яА-ЯA-Za-z]/', $request->surname)
            || (!preg_match('/[а-яА-ЯA-Za-z]/', $request->patronymic) && strlen($request->patronymic) > 0)) {
            return [
                'error' => true,
                'msg' => 'Имя содержит запрещенные символы'
            ];
        }

        $employee = Employee::with("departments")->find($request->id);
        if (!$employee) {
            return [
                'error' => true,
                'msg' => 'Работник не найден'
            ];
        }

        $employee->name = $request->name . " " . $request->surname;
        if ($request->patronymic) {
            $employee->name .= " " . $request->patronymic;
        }
        $employee->gender = (int)$request->gender;
        $employee->salary = $request->salary;
        $employee->save();

        $departments = $request->departments;

        $old_departments = $employee->departments->pluck("department.id")->toArray();

        $diffAdd = array_diff($departments, $old_departments);

        $diffDelete = array_diff($old_departments, $departments);

        foreach ($diffDelete as $value) {
            EmployeeDepartment::where([["employee_id", $employee->id], ["department_id", $value]])->delete();
        }

        $to_insert = [];

        foreach ($diffAdd as $value) {
            $to_insert[] = ['department_id' => $value, 'employee_id' => $employee->id];
        }

        EmployeeDepartment::insert($to_insert);

        return [
            'error' => false,
            'msg' => 'Данные о работнике успешно обновлены',
        ];
    }

    public function delete(Request $request)
    {
        $employee = Employee::find($request->id);
        if (!$employee) {
            return [
                'error' => true,
                'msg' => 'Указанного сотрудника не найдено'
            ];
        }

        EmployeeDepartment::where("employee_id", $employee->id)->delete();

        $employee->delete();

        return [
            'error' => false,
            'msg' => "Сотрудник успешно удален из базы",
            'redirect' => '/employees'
        ];
    }
}
