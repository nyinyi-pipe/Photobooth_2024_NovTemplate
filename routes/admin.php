<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\staffController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->middleware(['auth','verified','admin.moderator','pending'])->group(function(){
    //ticket
    Route::get('/ticket',[TicketController::class,'index'])->name("ticket.index");
    Route::post('/ticket',[TicketController::class,'store'])->name("ticket.store");
    Route::get('/ticket/{ticket}',[TicketController::class,'show'])->name("ticket.show");
    Route::patch('/ticket/{ticket}',[TicketController::class,'update'])->name("ticket.update");
    Route::delete('/ticket/{ticket}',[TicketController::class,'destroy'])->name("ticket.destroy");
    //ticket status
    Route::patch('/ticket/status/{ticket}',[TicketController::class,'changeStatus'])->name("ticket.status");
});


Route::prefix('admin')->middleware(['auth','verified','admin','pending'])->group(function(){
    //dashboard
    Route::get('/dashboard',[DashboardController::class,'index'])->name("dashboard");
    //report
    Route::get('/reports', [ReportController::class, 'index'])->name('report.index');
    //template
    Route::get('/template', [TemplateController::class, 'index'])->name('template.index');
    Route::post('/import/template', [TemplateController::class, 'store'])->name('template.store');
    Route::post('/template/{id}', [TemplateController::class, 'update'])->name('template.update');
    Route::delete('/template/{id}', [TemplateController::class, 'destroy'])->name('template.delete');
    //staff
    Route::get('/staffs', [staffController::class, 'index'])->name('staff.index');
    Route::patch('/staffs/{user}', [staffController::class, 'update'])->name('staff.update');
});
