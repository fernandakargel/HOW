<?php
use Modules\System\SystemController;
use Modules\System\UsersController;
use Modules\Pgestao\Department\DepartmentController;
use Modules\Pgestao\Role\RoleController;
use Modules\Pgestao\Process\ProcessController;
use Modules\Pgestao\Staff\StaffController;
use Modules\Pgestao\Company\CompanyController;
use Modules\Pgestao\Matrix\MatrixControlle;
use Modules\System\DataController;


/*
 * Module System
 * 
 * Calls for default functions of the system
 */


### System

// SystemController
$app->get('/', SystemController::class . ':home')->setName("home");
$app->post('/login', SystemController::class . ':login')->setName("login");
$app->get('/logout', SystemController::class . ':logout')->setName("logout");
$app->get('/logout/[{msg}]', SystemController::class . ':logout')->setName("logout");


//StaffController
$app->get('/staff', StaffController::class . ':list')->setName("staff.list");
$app->get('/staff/form', StaffController::class . ':form')->setName("staff.form");
$app->get('/staff/form/[{id}]', StaffController::class . ':form')->setName("staff.update");
$app->post('/staff/save', StaffController::class . ':save')->setName("staff.save");
$app->get('/staff/del/[{id}]', StaffController::class . ':del')->setName("staff.del");
$app->post('/staff/addskill', StaffController::class . ':addSkill')->setName("staff.addskill");
$app->get('/staff/delskill/[{param}]', StaffController::class . ':delSkill')->setName("staff.delskill");
$app->get('/staff/save/[{param}]', StaffController::class . ':save')->setName("staff.savestatus");


//CompanyController
$app->get('/company', CompanyController::class . ':list')->setName("company.list");
$app->get('/company/form', CompanyController::class . ':form')->setName("company.form");
$app->get('/company/form/[{id}]', CompanyController::class . ':form')->setName("company.update");
$app->post('/company/save', CompanyController::class . ':save')->setName("company.save");
$app->get('/company/del/[{id}]', CompanyController::class . ':del')->setName("company.del");


// UsersController
$app->get('/user', UsersController::class . ':list')->setName("users.list");
$app->get('/user/form', UsersController::class . ':form')->setName("users.form");
$app->get('/user/form/[{uid}]', UsersController::class . ':form')->setName("users.update");
$app->post('/user/save', UsersController::class . ':save')->setName("users.save");
$app->get('/user/del/[{uid}]', UsersController::class . ':del')->setName("users.del");
$app->get('/profile/[{uid}]', UsersController::class . ':profile')->setName("users.profile");
$app->post('/profile/save', UsersController::class . ':saveProfile')->setName("users.profile.save");

### Pgestao

//DepartmentController
$app->get('/department', DepartmentController::class . ':list')->setName("department.list");
$app->get('/department/form', DepartmentController::class . ':form')->setName("department.form");
$app->get('/department/form/[{id}]', DepartmentController::class . ':form')->setName("department.update");
$app->post('/department/save', DepartmentController::class . ':save')->setName("department.save");
$app->get('/department/del/[{id}]', DepartmentController::class . ':del')->setName("department.del");

//RoleController
$app->get('/role', RoleController::class . ':list')->setName("role.list");
$app->get('/role/form', RoleController::class . ':form')->setName("role.form");
$app->get('/role/form/[{id}]', RoleController::class . ':form')->setName("role.update");
$app->post('/role/save', RoleController::class . ':save')->setName("role.save");
$app->get('/role/del/[{id}]', RoleController::class . ':del')->setName("role.del");
$app->get('/role/by/department/[{department}]', RoleController::class . ':getByDepartment')->setName("role.bydepartment");

//ProcedureController
$app->get('/process', ProcessController::class . ':list')->setName("process.list");
$app->get('/process/form', ProcessController::class . ':form')->setName("process.form");
$app->get('/process/form/[{id}]', ProcessController::class . ':form')->setName("process.update");
$app->post('/process/save', ProcessController::class . ':save')->setName("process.save");
$app->get('/process/del/[{id}]', ProcessController::class . ':del')->setName("process.del");
$app->post('/process/savebydepartment', ProcessController::class . ':saveByDepartment')->setName("process.savebydepartment");
$app->get('/process/delbydepartment/[{param}]', ProcessController::class . ':delByDepartment')->setName("process.delbydepartment");



//MatrixController
$app->get('/matrix', MatrixControlle::class . ':list')->setName("matrix.list");
$app->post('/matrix/show', MatrixControlle::class . ':list')->setName("matrix.show");
$app->post('/matrix/print', MatrixControlle::class . ':print')->setName("matrix.print");

//DataController
$app->get('/data/import', DataController::class . ':list')->setName("data.import");