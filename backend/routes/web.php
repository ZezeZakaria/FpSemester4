<?php

use App\Http\Controllers\admin\DashboardCT;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'auth'])->name('login_store');
Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('dashboard/index', [DashboardCT::class, 'index'])->name('dashboard_index');

    // user route
    Route::resource('users', 'UsersController');
    // Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin-profile');
    Route::post('/profile/{id}', [AdminController::class, 'profileUpdate'])->name('profile-update');
    // Category
    Route::resource('/category', 'CategoryController');
    // Product
    Route::resource('/product', 'ProductController');
    // Order
    Route::resource('/order', 'OrderController');
    // Invoice
    Route::get("/invoice", [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get("/invoice/{id}/{judgement}", [InvoiceController::class, 'judgement'])->name('invoice.judgement');
    // Shipping
    Route::resource('/shipping', 'ShippingController');
    // Settings
    Route::get('settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('setting/update', [AdminController::class, 'settingsUpdate'])->name('settings.update');
    // Password Change
    Route::get('change-password', [AdminController::class, 'changePassword'])->name('change.password.form');
    Route::post('change-password', [AdminController::class, 'changPasswordStore'])->name('change.password');
});

// CACHE CLEAR ROUTE
Route::get('cache-clear', function () {
    Artisan::call('optimize:clear');
    request()->session()->flash('success', 'Successfully cache cleared.');
    return redirect()->back();
})->name('cache.clear');
