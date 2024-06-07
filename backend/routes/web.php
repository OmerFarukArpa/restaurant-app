<?php

use App\Http\Controllers\local\CategoryController;
use App\Http\Controllers\local\DashboardController;
use App\Http\Controllers\local\LoginController;
use App\Http\Controllers\local\MealController;
use App\Http\Controllers\local\MessageController;
use App\Http\Controllers\local\ReservationController;
use App\Http\Controllers\local\SettingController;
use App\Http\Controllers\local\TopicController;
use App\Http\Controllers\local\UserController;
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

Route::view('/','login')->name('login_page');
Route::post('/login',[LoginController::class,'login'])->name('login');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');

Route::prefix('/admin')->middleware(['auth','role-check'])->group(function (){
    Route::get('/index',[DashboardController::class,'show'])->name('index');

    Route::get('/reservations',[ReservationController::class,'show'])->name('reservations');
    Route::get('/reservation-detail',[ReservationController::class,'detail'])->name('reservation_detail');
    Route::post('/invoice-entry',[ReservationController::class,'invoiceEntry'])->name('invoice_entry');
    Route::post('/reservation-approval',[ReservationController::class,'reservationApproval'])->name('reservation_approval');
    Route::post('/reservation-cancel',[ReservationController::class,'reservationCancel'])->name('reservation_cancel');

    Route::get('/messages',[MessageController::class,'show'])->name('messages');
    Route::get('/message-detail',[MessageController::class,'detail'])->name('message_detail');

    Route::post('/add-topic',[TopicController::class,'store'])->name('add_topic');
    Route::post('/delete-topic',[TopicController::class,'delete'])->name('delete_topic');


    Route::get('/users',[UserController::class,'show'])->name('users');
    Route::post('/user-change-status',[UserController::class,'changeStatus'])->name('user_change_status');
    Route::get('/user-detail',[UserController::class,'detail'])->name('user_detail');

    Route::get('/settings',[SettingController::class,'show'])->name('settings');
    Route::post('/settings',[SettingController::class,'update']);

    Route::post('/add-country',[CountryController::class,'store'])->name('add_country');
    Route::post('/delete-country',[CountryController::class,'delete'])->name('delete_country');

    Route::get('/foods/{id}',[MealController::class,'show'])->name('foods');
    Route::post('/add-category',[CategoryController::class,'store'])->name('add_category');
    Route::post('/delete-category',[CategoryController::class,'delete'])->name('delete_category');

    Route::post('/meal-status',[MealController::class,'changeStatus'])->name('change_status');
    Route::get('/meal-edit',[MealController::class,'edit'])->name('meal_edit');
    Route::post('/meal-edit',[MealController::class,'update']);
    Route::post('/meal_add',[MealController::class,'store'])->name('meal_add');
    Route::post('/meal-delete',[MealController::class,'delete'])->name('meal_delete');
    Route::get('/meal-detail',[MealController::class,'detail'])->name('meal_detail');
});
