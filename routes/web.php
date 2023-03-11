<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoggingController;
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

Route::get('/login', [LoggingController::class,'index'])->name('login');


// Route::get('/', [DashboardController::class,'index']);
// Route::get('/show', [DashboardController::class,'show']);


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/task', 'TaskController@index')->name('task');


Route::fallback(function(){
    if (!Auth::user()) {
        return redirect()->to('/login');
    }else{
        return redirect()->to('/home');
    }
});
Auth::routes();
