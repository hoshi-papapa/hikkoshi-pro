<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubUserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TemplateTaskController;
use App\Http\Controllers\MyPageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', [TaskController::class, 'index']);
    Route::resource('tasks', TaskController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage.index');
    Route::get('/mypage/edit', [MyPageController::class, 'edit'])->name('mypage.edit');
    Route::patch('/mypage/update', [MyPageController::class, 'update'])->name('mypage.update');

    Route::get('/subusers', [SubUserController::class, 'index'])->name('subusers.index');
    Route::get('/subusers/create', [SubUserController::class, 'create'])->name('subusers.create');
    Route::post('/subusers', [SubUserController::class, 'store'])->name('subusers.store');
    Route::get('/subusers/{subUser}/edit', [SubUserController::class, 'edit'])->name('subusers.edit');
    Route::put('/subusers/{subUser}', [SubUserController::class, 'update'])->name('subusers.update');
    Route::delete('/subusers/{subUser}', [SubUserController::class, 'destroy'])->name('subusers.destroy');
});

Route::resource('users', UserController::class);
Route::resource('templatetasks', TemplateTaskController::class)->only(['index']);

//Route::resource('tasks', TaskController::class);


require __DIR__ . '/auth.php';
