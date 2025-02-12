<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingsController;

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


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);



Route::post('/validate-username', [RegisterController::class, 'validateUsername'])->name('validate.username');
Route::post('/validate-email', [RegisterController::class, 'validateEmail'])->name('validate.email');

Route::get('/', function () {
    return view('welcomePage');
});

Route::middleware(['auth', 'check.user.status'])->group(function () {

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/dashboard', function () {
        return view('app');
    })->name('dashboard');


    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/check-password', [SettingsController::class, 'checkPassword'])->name('check-password');


    //product
    Route::post('/storeProduct', [ProductController::class, 'store'])->name('storeProduct');
    Route::delete('/delete-product/{id}', [ProductController::class, 'destroy'])->name('deleteProduct');
    Route::get('/getProductData', [ProductController::class, 'getProductData'])->name('getProductData');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/sales/product/{productId}', [ProductController::class, 'getSalesCategories']);
    Route::get('/singleProduct/{id}', [ProductController::class, 'showSingleproduct']); // For fetching product details
    Route::put('/singleProduct/{id}', [ProductController::class, 'update']);

    Route::get('/settings', [SettingsController::class, 'showSettingsPage'])->name('settings');
    Route::post('/settings/update', [SettingsController::class, 'updateSettings'])->name('update-settings');
    Route::delete('/settings/delete', [SettingsController::class, 'deleteAccount'])->name('delete-account');

    Route::delete('/profile/photo/delete', [AuthController::class, 'deletePhoto'])->name('profile.photo.delete');

    Route::get('/products', function () {
        return view('products.show');
    })->name('products.index');

    //category
    Route::post('/categories', [CategoryController::class, 'store'])->name('storeCat');
    Route::delete('/delete-category/{id}', [CategoryController::class, 'destroy'])->name('deleteCategory');
    Route::put('/categories/{id}', [CategoryController::class, 'update']);

    //bills
    Route::post('/storeBill', [BillController::class, 'store'])->name('storeBill');
    Route::get('getProductName', [BillController::class, 'getProductName'])->name('getProductName');
    Route::get('/sales/{id}', [BillController::class, 'getBillDetails'])->name('getBillDetails');
    Route::get('/sales/categories/{productId}', [BillController::class, 'getProductSalesCategories']);

    //sales
    Route::get('/getSalesData', [BillController::class, 'getSalesData'])->name('getSalesData');
    Route::get('/getAllSales', [BillController::class, 'getAllSales'])->name('getAllSales');

    //sales
    Route::get('/sales/total/{category}', [SalesController::class, 'getTotalSales']);
});
