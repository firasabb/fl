<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'WelcomeController@index')->name('welcome.index');

Auth::routes();

// Check Username AJAX

Route::post('/register/checkusername', 'Auth\RegisterController@checkusername')->name('checkusername');

// Get Tags AJAX

Route::post('/create/question/tags', 'PreQuestionController@suggestTags')->name('suggesttags');

//

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin/dashboard', 'AdminController@index')->name('admin.dashboard');

// Admin / Users
Route::get('/admin/dashboard/users', 'AdminController@indexUsers')->name('admin.index.users');
Route::delete('/admin/dashboard/user/{id}', 'AdminController@destroyUser')->name('admin.delete.user');
Route::get('/admin/dashboard/user/{id}', 'AdminController@showUser')->name('admin.show.user');
Route::put('/admin/dashboard/user/{id}', 'AdminController@editUser')->name('admin.edit.user');
Route::post('/admin/dashboard/users/add', 'AdminController@addUser')->name('admin.add.user');
Route::post('/admin/dashboard/users/search', 'AdminController@searchUsers')->name('admin.search.users');
Route::get('/admin/dashboard/user/{id}/generate/password', 'AdminController@generatePassword')->name('admin.generate.password.user');


// Admin / Roles

Route::get('/admin/dashboard/roles', 'AdminController@indexRoles')->name('admin.index.roles');
Route::delete('/admin/dashboard/role/{id}', 'AdminController@destroyRole')->name('admin.delete.role');
Route::get('/admin/dashboard/role/{id}', 'AdminController@showRole')->name('admin.show.role');
Route::put('/admin/dashboard/role/{id}', 'AdminController@editRole')->name('admin.edit.role');
Route::post('/admin/dashboard/roles', 'AdminController@addRole')->name('admin.add.role');


// Admin / Permissions

Route::get('/admin/dashboard/permissions', 'AdminController@indexPermissions')->name('admin.index.permissions');
Route::delete('/admin/dashboard/permission/{id}', 'AdminController@destroyPermission')->name('admin.delete.permission');
Route::get('/admin/dashboard/permission/{id}', 'AdminController@showPermission')->name('admin.show.permission');
Route::put('/admin/dashboard/permission/{id}', 'AdminController@editPermission')->name('admin.edit.permission');
Route::post('/admin/dashboard/permissions', 'AdminController@addPermission')->name('admin.add.permission');



// Admin / PreQuestions

Route::get('/admin/dashboard/prequestions/', 'PreQuestionController@index')->middleware('role:admin|moderator')->name('admin.index.prequestions');
Route::delete('/admin/dashboard/prequestion/{id}', 'PreQuestionController@destroy')->middleware('role:admin|moderator')->name('admin.delete.prequestion');
Route::post('/admin/dashboard/prequestions/', 'PreQuestionController@approve')->middleware('role:admin|moderator')->name('admin.approve.prequestion');


// Admin / Questions

Route::get('/admin/dashboard/questions/', 'QuestionController@adminIndex')->middleware('role:admin|moderator')->name('admin.index.questions');
Route::delete('/admin/dashboard/question/{id}', 'QuestionController@adminDestroy')->middleware('role:admin|moderator')->name('admin.delete.question');
Route::get('/admin/dashboard/question/{id}', 'QuestionController@adminShow')->middleware('role:admin|moderator')->name('admin.show.question');
Route::put('/admin/dashboard/question/{id}', 'QuestionController@adminEdit')->middleware('role:admin|moderator')->name('admin.edit.question');
Route::post('/admin/dashboard/question/', 'QuestionController@adminAdd')->middleware('role:admin|moderator')->name('admin.add.question');
Route::post('/admin/dashboard/questions/search', 'QuestionController@adminSearchQuestions')->middleware('role:admin|moderator')->name('admin.search.questions');


// Admin / Tags

Route::get('/admin/dashboard/tags/', 'TagController@adminIndex')->middleware('role:admin|moderator')->name('admin.index.tags');
Route::delete('/admin/dashboard/tag/{id}', 'TagController@adminDestroy')->middleware('role:admin|moderator')->name('admin.delete.tag');
Route::get('/admin/dashboard/tag/{id}', 'TagController@adminShow')->middleware('role:admin|moderator')->name('admin.show.tag');
Route::put('/admin/dashboard/tag/{id}', 'TagController@adminEdit')->middleware('role:admin|moderator')->name('admin.edit.tag');
Route::post('/admin/dashboard/tag/', 'TagController@adminAdd')->middleware('role:admin|moderator')->name('admin.add.tag');
Route::post('/admin/dashboard/tags/search', 'TagController@adminSearchTags')->middleware('role:admin|moderator')->name('admin.search.tags');


// Admin / Categories

Route::get('/admin/dashboard/categories/', 'CategoryController@adminIndex')->middleware('role:admin|moderator')->name('admin.index.categories');
Route::delete('/admin/dashboard/categorie/{id}', 'CategoryController@adminDestroy')->middleware('role:admin|moderator')->name('admin.delete.category');
Route::get('/admin/dashboard/category/{id}', 'CategoryController@adminShow')->middleware('role:admin|moderator')->name('admin.show.category');
Route::put('/admin/dashboard/category/{id}', 'CategoryController@adminEdit')->middleware('role:admin|moderator')->name('admin.edit.category');
Route::post('/admin/dashboard/category/', 'CategoryController@adminAdd')->middleware('role:admin|moderator')->name('admin.add.category');
Route::post('/admin/dashboard/categories/search', 'CategoryController@adminSearchCategories')->middleware('role:admin|moderator')->name('admin.search.categories');


// Admin / Answers

Route::get('/admin/dashboard/answers/', 'AnswerController@adminIndex')->middleware('role:admin|moderator')->name('admin.index.answers');


// Admin / Reports

Route::get('/admin/dashboard/reports/', 'ReportController@adminIndex')->middleware('role:admin|moderator')->name('admin.index.reports');
Route::delete('/admin/dashboard/report/{id}', 'ReportController@adminDestroy')->middleware('role:admin|moderator')->name('admin.delete.report');
Route::get('/admin/dashboard/report/{id}', 'ReportController@adminShow')->middleware('role:admin|moderator')->name('admin.show.report');
Route::put('/admin/dashboard/report/{id}', 'ReportController@adminEdit')->middleware('role:admin|moderator')->name('admin.edit.report');
Route::post('/admin/dashboard/report/', 'ReportController@adminAdd')->middleware('role:admin|moderator')->name('admin.add.report');
Route::post('/admin/dashboard/report/search', 'ReportController@adminSearchReports')->middleware('role:admin|moderator')->name('admin.search.reports');


// PreQuestions

Route::get('/ask/question', 'PreQuestionController@create')->name('create.prequestion');
Route::post('/ask/question', 'PreQuestionController@store')->name('store.prequestion');


// Question

Route::get('/question/{url}', 'QuestionController@show')->name('show.question');


// Users

Route::get('/user/{username}', 'UserController@showProfile')->name('user.profile');

// Tags

Route::get('/tags', 'TagController@index')->name('index.tags');

// Answers

Route::post('/answer/create/{token}', 'AnswerController@store')->middleware('role:user')->name('add.answer');