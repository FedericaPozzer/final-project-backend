<?php

use App\Http\Controllers\admin\DishController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\RestaurantController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Mail;
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

// * Restaurants
Route::resource('restaurants', RestaurantController::class);
Route::get('restaurant/trash', [RestaurantController::class, 'trash'])->name('restaurants.trash');


// * Dishes
Route::resource('dishes', DishController::class);
Route::put("dishes/{dish}/restore", [DishController::class, "restore"])->name("dishes.restore");
Route::delete("dishes/{dish}/force-delete", [DishController::class, "forceDelete"])->name("dishes.force-delete");

Route::get('send-customer_mail', function ($user_customer) {
   
    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];
   
    Mail::to($user_customer)->send(new \App\Mail\MyTestMail($details));
   
    dd("Email is Sent.");
})->name('customer.mail');



Route::get('send-restaurant', function ($email_restaurant) {
   
    dd("Email is Sent.");
})->name('restaurant.mail');




// * Orders 
Route::middleware('auth','verified')->group(function () {
    Route::get('orders', [RestaurantController::class, 'orders'])->name('restaurants.orders');
    Route::get('orders/shipped/{id}', [OrderController::class, 'shipped'])->name('order.shipped');
});

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

require __DIR__.'/auth.php';