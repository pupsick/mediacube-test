<?php
return [
    'fetchData' => [
        'Employees' => 'App\\Http\\Controllers\\Employees\\EmployeeController@show',
        'EmployeeItem' => 'App\\Http\\Controllers\\Employees\\EmployeeController@edit',
        'EmployeeAdd' => 'App\\Http\\Controllers\\Employees\\EmployeeController@add',
        'Departments' => 'App\\Http\\Controllers\\Departments\\DepartmentController@show',
        'DepartmentItem' => 'App\\Http\\Controllers\\Departments\\DepartmentController@edit',
        'Home' => 'App\\Http\\Controllers\\CoreController@mainPageData',
    ]
];