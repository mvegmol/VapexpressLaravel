<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
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

Route::get('/', function () {
    return view('index');
});
Route::get('/home', function () {
    return view('auth');
})->middleware(['auth', 'verified']);


// User URL
Route::get('/profile', [UsersController::class, 'profile'])->name('user.profile');
Route::get('/user/edit/{id}', [UsersController::class, 'edit'])->name('user.edit');
Route::put('/user/{id}', [UsersController::class, 'update'])->name('user.update');
Route::view('/profile/password', 'auth.password')->name('user.edit_password');
// Address URL

//Categories URL

//Orders URL

//Products URL

//Shopping Cart URL

//Suppliers URL
