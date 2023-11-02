<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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


//Old code 
/*Route::get('/', function () {
    return redirect("/dashboard");
});*/

Route::get('/', function () {
    return redirect("/dashboard");
})->name('Dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware("auth")->name('dashboard');
Route::get('/lists', [ListController::class, 'index'])->middleware("auth")->name('lists');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
