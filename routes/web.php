<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::middleware(["auth", "role:admin|moderator|author"])->prefix("admin")->as("admin.")->group(function () {
    Route::view("/", "admin.dashboard")->name("dashboard");
    Route::view("/users", "admin.user")->name("users");
    Route::view("/roles-and-permissions", "admin.role")->name("roles-and-permissions");
});
