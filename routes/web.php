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
Route::get('/workspace', 'WorkspaceController@index')->name('workspace');
// Route::get('/task', 'TaskController@index')->name('task');
Route::post('/add-new-card', 'TaskController@addNewCard');
Route::post('/add-new-list', 'TaskController@addNewList');
Route::post('/change-list-task-position', 'TaskController@changePosition');
Route::post('/archive-list-task', 'TaskController@archive');
Route::post('/change-list-task-title', 'TaskController@changeTitle');

// workspace
Route::post('/create-new-workspace', 'WorkspaceController@createNewWorkspace');
Route::get('/workspace/{id}', 'WorkspaceController@getWorkspace');

Route::fallback(function(){
    if (!Auth::user()) {
        return redirect()->to('/login');
    }else{
        return redirect()->to('/home');
    }
});
Auth::routes();
