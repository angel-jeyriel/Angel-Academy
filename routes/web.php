<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestAttemptController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('staff')->name('staff.')->group(function () {
        Route::resource('tests', TestController::class);
        Route::get('tests/{test}/results', [TestController::class, 'results'])->name('tests.results');
        Route::get('tests/{test}/pdf', [TestController::class, 'generatePdf'])->name('tests.pdf');

        Route::get('tests/course/create', [TestController::class, 'createCourse'])->name('create.course');
        Route::post('tests/course/add', [TestController::class, 'addCourse'])->name('add.course');

        Route::get('tests/subject/create', [TestController::class, 'createSubject'])->name('create.subject');
        Route::post('tests/subject/add', [TestController::class, 'addSubject'])->name('add.subject');
    });

    Route::prefix('student')->name('student.')->group(function () {
        Route::get('dashboard', [TestAttemptController::class, 'dashboard'])->name('dashboard');
        Route::get('test/{test}/start', [TestAttemptController::class, 'start'])->name('test.start');
        Route::post('test/{attempt}/submit', [TestAttemptController::class, 'submit'])->name('test.submit');
        Route::get('results/{attempt}', [TestAttemptController::class, 'results'])->name('results');
    });
});

Route::get('/run-migration', function () {
    Artisan::call('optimize:clear');
    Artisan::call('migrate:refresh --seed');

    return "Migrations executed successfully!";
});

require __DIR__ . '/auth.php';
