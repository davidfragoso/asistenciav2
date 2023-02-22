<?php

use Illuminate\Support\Facades\Route;
//agregamos los siguientes controladores
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleDeleteController;
use App\Http\Controllers\ScheduleDataController;
use App\Http\Controllers\AttendanceController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//y creamos un grupo de rutas protegidas para los controladores
Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('blogs', BlogController::class);


    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/attendances/create', [AttendanceController::class, 'create'])->name('attendances.create');
    Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::get('/attendances/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendances.edit');
    Route::put('/attendances/{attendance}', [AttendanceController::class, 'update'])->name('attendances.update');
    Route::delete('/attendances/{id}', [AttendanceController::class, 'destroy'])->name('attendances.destroy');
    Route::post('/markAttendance', [AttendanceController::class, 'markAttendance'])->name('attendance.mark');
    Route::post('/markDeparture', [AttendanceController::class, 'markDeparture'])->name('attendance.departure');



    // Route::get('/attendance/assign', [AttendanceController::class, 'assign'])->name('attendance.assign');
    // Route::get('/leave/assign', [AttendanceController::class, 'leave'])->name('leave.assign');



    Route::get('schedules', [ScheduleController::class, 'index'])->name('schedules.index'); //vista principal de horarios
    Route::get('schedules/create', [ScheduleController::class, 'create'])->name('schedules.create'); // vista de creación de un nuevo horario fijo
    Route::post('schedules', [ScheduleController::class, 'store'])->name('schedules.store'); // almacenar los datos de un nuevo horario fijo
    Route::get('schedules/{schedules}/edit', [ScheduleController::class, 'edit'])->name('schedules.edit'); // vista de edición de un horario fijo existente
    Route::put('schedules/{schedules}', [ScheduleController::class, 'update'])->name('schedules.update'); // actualizar los datos de un horario fijo existente
    Route::delete('schedules/{id}', [ScheduleController::class, 'destroy'])->name('schedules.destroy'); // eliminar un horario fijo existente

});
