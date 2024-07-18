<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AddressesController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
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
Route::middleware(['admin'])->group(function () {

    Route::get("/categories", [CategoriesController::class, "index"])->name("categories.index");
    Route::get("/categories/create", [CategoriesController::class, "create"])->name("categories.create");
    Route::post("/categories", [CategoriesController::class, "store"])->name("categories.store");
    Route::delete("/categories/{category}", [CategoriesController::class, "destroy"])->name("categories.destroy");
    Route::get("/categories/{category}/edit", [CategoriesController::class, "edit"])->name("categories.edit");
    Route::put("/categories/{category}", [CategoriesController::class, "update"])->name("categories.update");
    Route::get('categories/{category}/products', [CategoriesController::class, 'products'])->name('categories.products');
    Route::post('categories/{category}/products', [CategoriesController::class, 'storeProduct'])->name('categories.products.store');
    Route::delete('categories/{category}/products/{product}', [CategoriesController::class, 'destroyProduct'])->name('categories.products.destroy');
});
//Orders URL

//Products URL

//Products URL (Admin)
Route::middleware(['admin'])->group(function () {
    Route::get("/products", [ProductsController::class, "index"])->name("products.index");
    Route::get("/products/create", [ProductsController::class, "create"])->name("products.create");
    Route::post("/products", [ProductsController::class, "store"])->name("products.store");
    Route::delete("/products/{product}", [ProductsController::class, "destroy"])->name("products.destroy");
    Route::get("/products/{product}/edit", [ProductsController::class, "edit"])->name("products.edit");
    Route::put("/products/{product}", [ProductsController::class, "update"])->name("products.update");
    Route::get("/products/{product}/show", [ProductsController::class, "show"])->name("products.show");
});

//Shopping Cart URL

//Suppliers URL

Route::middleware(['admin'])->group(function () {
    // Add todas las rutas de proveedores para el admin
    // Hay que tener en cuenta que lo voy a meter en la carpeta admin
    // para dentro una carpeta llamada proveedores
    Route::get("/suppliers", [SuppliersController::class, "index"])->name("suppliers.index");
    Route::get("/suppliers/create", [SuppliersController::class, "create"])->name("suppliers.create");
    Route::post("/suppliers", [SuppliersController::class, "store"])->name("suppliers.store");
    Route::delete("/suppliers/{supplier}", [SuppliersController::class, "destroy"])->name("suppliers.destroy");
    Route::get("/suppliers/{supplier}/edit", [SuppliersController::class, "edit"])->name("suppliers.edit");
    Route::put("/suppliers/{supplier}", [SuppliersController::class, "update"])->name("suppliers.update");
});
