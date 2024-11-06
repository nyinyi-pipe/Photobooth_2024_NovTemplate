<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ReadyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TemplateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;

//admin
require __DIR__.'/admin.php';


//ready
Route::get('/ready', [ReadyController::class,'index'])->name('ready.index');

// Contact
Route::get('/contact', [ContactController::class,'index'])->name('contact.index');

//client
Route::middleware(['auth','verified','pending'])->group(function () {
    //payment
    Route::get('/payment', [PaymentController::class,'index'])->name('payment.index');
    Route::post('/payment', [PaymentController::class,'store'])->name('payment.store');
    // Route::post('/payment/cash',[PaymentController::class,'checkCash'])->name('payment.cash');
    Route::get('/payment/method', [PaymentController::class,'method'])->name('payment.method');

    //profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //test
    Route::get('/test', function () {
        return Inertia::render('Test');
    })->name('test');
});

Route::group(['middleware'=>['auth','verified','pending','camera']], function () {
    //camera
    Route::get('/camera', [PhotoController::class,'clientIndex'])->name('client.index');
    Route::get('/camera/check-template', [TemplateController::class,'checkTemplate'])->name('template.check');
    Route::post('/camera', [PhotoController::class,'store'])->name('client.store');
    //filter
    Route::get('/photo/filter', [PhotoController::class,'filter'])->name('photo.filter');
    Route::patch('/photo/filter', [PhotoController::class,'filterColor'])->name('photo.filterColor');
    //qrcode
    Route::get('/photo/qrcode/{photo}', [PhotoController::class,'qrcode'])->name('photo.qrcode');
    //photos
    Route::get('/photos', [PhotoController::class,'index'])->name('photo.index');
    Route::get('/photos/{photo}', [PhotoController::class,'show'])->name('photo.show');
});

//pending
Route::get('/user/pending', function () {
    return Inertia::render('Pending/Index', [
        'role'=>auth()->user()->getRoleNames()->first()
    ]);
})->name('pending');

Route::get('/', [HomeController::class,'index'])->name('front.index');
Route::get('/photo/download/{photo}', [PhotoController::class,'downloadIndex'])->name('photo.download');


Route::get('/tests', TestController::class)->name('tests');



require __DIR__.'/auth.php';
