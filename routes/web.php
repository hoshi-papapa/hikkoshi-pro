<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubUserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TemplateTaskController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/templatetasks/test', function () {
    $templateTasks = App\Models\TemplateTask::all();
    return view('templatetasks.index', compact('templateTasks'));
});

Route::resource('users', UserController::class);
Route::resource('subusers', SubUserController::class);
Route::resource('templatetasks', TemplateTaskController::class)->only(['index']);
Route::resource('tasks', TaskController::class);

require __DIR__ . '/auth.php';
