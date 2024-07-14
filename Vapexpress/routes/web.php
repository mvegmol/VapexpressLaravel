<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AddressesController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SuppliersController;
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

Route::get("/", function () {
    return view("index");
});

Route::get("/home", function () {
    if (Auth::check()) {
        return view("index");
    } else {
        return view("auth.dashboard");
    }
})->middleware(["auth", "verified"]);

// User URL
Route::get("/profile", [UsersController::class, "profile"])
    ->name("user.profile")
    ->middleware(["auth", "verified"]);
Route::get("/user/edit/{id}", [UsersController::class, "edit"])->name(
    "user.edit"
);
Route::put("/user/{id}", [UsersController::class, "update"])->name(
    "user.update"
);
Route::view("/profile/password", "auth.password")->name("user.edit_password");

// Address URL
Route::middleware(["auth"])->group(function () {
    Route::resource("/addresses", AddressesController::class);
    Route::put("/addresses/changue/{address}", [
        AddressesController::class,
        "changeDefault",
    ])->name("addresses.change");
});
//Categories URL
/*Route::group(function () {
    if (Auth::check() && Auth::user()->role == "admin") {
        // Add todas las rutas de categorias para el admin
        // Hay que tener en cuenta que lo voy a meter en la carpeta admin
        // para dentro una carpeta llamada categories
        //Route::resource("/categories", CategoriesController::class);
    }
});*/
//Orders URL

//Products URL

//Shopping Cart URL

//Suppliers URL

Route::middleware(['admin'])->group(function () {
    // Add todas las rutas de proveedores para el admin
    // Hay que tener en cuenta que lo voy a meter en la carpeta admin
    // para dentro una carpeta llamada proveedores
    Route::get("/suppliers", [SuppliersController::class, "index"])->name("suppliers.index");
});
