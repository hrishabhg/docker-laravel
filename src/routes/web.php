<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('teachers', '\App\Http\Controllers\TeacherController');
Route::get('teachers/{id}/students', [\App\Http\Controllers\TeacherController::class, 'students'])->name('teachers.students');
Route::get('teachers/{id}/add-students', [\App\Http\Controllers\TeacherController::class, 'addStudents'])->name('teachers.addStudents');
Route::get('teachers/{teacherId}/remove-student/{studentId}', [\App\Http\Controllers\TeacherController::class, 'removeStudent'])->name('teachers.removeStudent');
Route::put('teachers/{teacherId}/mark-star/{studentId}', [\App\Http\Controllers\TeacherController::class, 'markStar'])->name('teachers.markStar');
