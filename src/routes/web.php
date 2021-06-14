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
    return redirect('/teachers');
});

Route::resource('teachers', '\App\Http\Controllers\TeacherController');
Route::get('teachers/{id}/students', [\App\Http\Controllers\TeacherController::class, 'students'])->name('teachers.students');
Route::get('teachers/{id}/add-students', [\App\Http\Controllers\TeacherController::class, 'addStudents'])->name('teachers.addStudents');
Route::put('teachers/{teacherId}/attach-student/{studentId}', [\App\Http\Controllers\TeacherController::class, 'attachStudent'])->name('teachers.attachStudent');
Route::delete('teachers/{teacherId}/detach-student/{studentId}', [\App\Http\Controllers\TeacherController::class, 'detachStudent'])->name('teachers.detachStudent');
Route::put('teachers/{teacherId}/mark-star/{studentId}', [\App\Http\Controllers\TeacherController::class, 'markStar'])->name('teachers.markStar');

Route::resource('students', '\App\Http\Controllers\StudentController');
