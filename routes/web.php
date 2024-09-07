<?php

use Illuminate\Support\Facades\Route;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/manager/user/trash', [App\Http\Controllers\UserManagerController::class, 'indextrash'])->name('manager.user.indextrash');


Route::get('/manager/project/{projectid}/user/{userid}/task/{taskid}/note/{noteid}', [App\Http\Controllers\TaskManagerController::class, 'notedelete'])->name('manager.project.task.notedelete');



Route::get('/manager/project/trash/', [App\Http\Controllers\ProjectManagerController::class, 'indextrash'])->name('manager.project.indextrash');
Route::get('/manager/project/trash/{projectid}', [App\Http\Controllers\ProjectManagerController::class, 'restoretrash'])->name('manager.project.restoretrash');
Route::delete('/manager/project/trash/{projectid}', [App\Http\Controllers\ProjectManagerController::class, 'destroytrash'])->name('manager.project.destroytrash');


Route::resource('/manager/user', App\Http\Controllers\UserManagerController::class, ['as' => 'manager']);
Route::resource('/manager/{projectid}/{userid}/task', App\Http\Controllers\TaskManagerController::class, ['as' => 'manager']);
Route::put('/manager/project/{projectid}/user/{userid}/task/{taskid}/complete', [App\Http\Controllers\TaskManagerController::class, 'taskcomplete'])->name('manager.task.complete');

Route::put('/manager/project/{projectid}/user/{userid}/task/{taskid}/restore', [App\Http\Controllers\TaskManagerController::class, 'taskcompleterestore'])->name('manager.task.completerestore');


Route::resource('/manager/project', App\Http\Controllers\ProjectManagerController::class , ['as' => 'manager']);

Route::get('/manager/project/adduser/{id}', [App\Http\Controllers\ProjectManagerController::class, 'adduser'])->name('manager.project.adduser');

Route::get('/manager/project/{id}/tasks', [App\Http\Controllers\ProjectManagerController::class, 'task'])->name('manager.project.task');

Route::get('/manager/user/trash/{userid}', [App\Http\Controllers\UserManagerController::class, 'restoretrash'])->name('manager.user.restoretrash');
Route::delete('/manager/user/trash/{userid}', [App\Http\Controllers\UserManagerController::class, 'destroytrash'])->name('manager.user.destroytrash');

Route::get('/manager/project/{projectid}/user/{userid}/task/complete', [App\Http\Controllers\TaskManagerController::class, 'taskcompleteindex'])->name('manager.task.completeindex');








Route::post('/manager/project/storeuser', [App\Http\Controllers\ProjectManagerController::class, 'storeuser'])->name('manager.project.storeuser');

Route::delete('/manager/project/removeuser/{projectid}/{userid}', [App\Http\Controllers\ProjectManagerController::class, 'removeuser'])->name('manager.project.removeuser');



Route::get('/manager', [App\Http\Controllers\ManagerController::class, 'index'])->name('manager');

Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');

Route::get('/user/project/{projectid}', [App\Http\Controllers\UserController::class, 'indextask'])->name('user.task.index');

Route::get('/user/project/{projectid}/task/{taskid}', [App\Http\Controllers\UserController::class, 'submitform'])->name('user.task.submitform');

Route::get('/user/project/{projectid}/task/{taskid}/image/{imageid}', [App\Http\Controllers\UserController::class, 'submitedit'])->name('user.task.submitedit');

Route::post('/user/project/{projectid}/task/{taskid}', [App\Http\Controllers\UserController::class, 'submit'])->name('user.task.submit');

Route::put('/user/project/{projectid}/task/{taskid}/image/{imageid}', [App\Http\Controllers\UserController::class, 'submitupdate'])->name('user.task.submitupdate');

Route::delete('/user/project/{projectid}/task/{taskid}/image/{imageid}/delete', [App\Http\Controllers\UserController::class, 'submitdelete'])->name('user.task.submitdelete');

Route::post('/user/project/{projectid}/task/{taskid}/submit', [App\Http\Controllers\UserController::class, 'submittask'])->name('user.task.submittask');

Route::post('/user/project/{projectid}/task/{taskid}/submit/delete', [App\Http\Controllers\UserController::class, 'submitcancel'])->name('user.task.submitcancel');





Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');

Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/manager/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');

Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

