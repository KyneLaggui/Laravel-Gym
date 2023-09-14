<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TrackerController;
use App\Http\Controllers\GymEquipmentsController;

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
    return view('view');
});

//Yung name is yung name ng tatawagin, yung katabi nung class ayun yung tatawagin sa function sa controller tapos yung una yung sa routing 
//Post is for getting the values, mostly sa form
//Get yung mga nasa URL
Route::get('login', [AuthController::class, 'index'])-> name('login');
Route::get('registration', [AuthController::class, 'registration'])-> name('registration');
Route::post('post-registration', [AuthController::class, 'postRegistration'])-> name('registration.post');
Route::post('post-login', [AuthController::class, 'postLogin'])-> name('login.post');
Route::post('post-products', [AuthController::class, 'storeProduct'])-> name('storeProducts.post');
Route::get('dashboard', [AuthController::class, 'dashboard'])-> name('dashboard');
Route::get('logout', [AuthController::class, 'logout'])-> name('logout');
Route::get('createProduct', [AuthController::class, 'createProduct'])-> name('createProduct');
Route::get('/taskSchedule', [AuthController::class, 'taskSchedule'])-> name('taskSchedule');
Route::post('/taskSchedule/action', [AuthController::class, 'receiveSchedule']);
Route::get('/calorieTracker', [TrackerController::class, 'calorieTracker'])-> name('calorieTracker');
Route::post('/storeTracker', [TrackerController::class, 'storeTracker'])-> name('storeTracker');
Route::post('/calorieTracker', [TrackerController::class, 'storeMeal'])->name('storeMeal');
Route::delete('/{tracker}', [TrackerController::class, 'deleteTracker'])-> name('deleteTracker');

Route::get('/equipments/edit/{id}', [AuthController::class, 'edit'])->name('editEquipments');
Route::get('put-equipments/{id}', [AuthController::class, 'update'])->name('updateEquipments.put');
Route::delete('delete-equipments/{id}', [AuthController::class, 'delete'])->name('deleteEquipments');
Route::get('usersList', [AuthController::class, 'listUser'])-> name('usersList');
Route::patch('/users/{id}/update-level', [AuthController::class, 'updateUserLevel'])->name('updateUserLevel');
Route::delete('delete-users/{id}', [AuthController::class, 'deleteUser'])->name('deleteUser');

