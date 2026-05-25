<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('dashboard');
    // Route::get('/', function () {
    //     return view('/pages/dashboard/staff');
    // })->middleware(['auth', 'verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //tasks
    Route::get('/task', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/task/form', [TaskController::class, 'create'])->name('tasks.form');
    Route::get('/task/form/{task}', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::get('/task/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/task', [TaskController::class, 'store'])->name('tasks.store');            

    // Route::get('/task/show', function() {
    //     return view('pages.tasks.show');
    // })->name('tasks.show');
    //project
    Route::get('/project', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/project/form', [ProjectController::class, 'create'])->name('projects.form');    
    Route::get('/project/form/{project}', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::post('/project', [ProjectController::class, 'store'])->name('projects.store');
    Route::post('/project/{project}', [ProjectController::class, 'update'])->name('projects.update');    
    Route::delete('/project/{id}', [ProjectController::class, 'destroy'])->name('projects.delete');

    //reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    //employee
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employees.index');    
});

require __DIR__.'/auth.php';
