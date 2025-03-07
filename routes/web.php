<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoggingController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TikTokController;
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
Route::post('/get-participant-list', 'TaskController@getParticipantList');
Route::post('/invite-participant', 'TaskController@inviteParticipant');
Route::post('/remove-participant', 'TaskController@removeParticipant');

// setting
Route::get('/setting', 'SettingController@index')->name('setting');
Route::post('/setting/reset/medias', 'SettingController@resetMedias')->name('setting');
Route::post('/setting/reset/manga', 'SettingController@resetManga')->name('setting');
Route::post('/setting/convert/video', 'SettingController@convertVideo')->name('convert-video');
Route::post('/setting/merge/video', 'SettingController@mergeVideo')->name('convert-video');

// workspace
Route::post('/create-new-workspace', 'WorkspaceController@createNewWorkspace');
Route::post('/archive-workspace', 'WorkspaceController@archiveWorkspace');
Route::post('/edit-workspace', 'WorkspaceController@editWorkspace');
Route::get('/workspace/{id}', 'WorkspaceController@getWorkspace');

// video
// Route::get('/videos', 'VideoController@index');
Route::get('/videos/menu/{menu}', 'VideoController@getByMenu');
Route::resource('/videos', 'VideoController');
Route::resource('/manga', 'MangaController');
Route::get('/videos-folder', 'VideoController@folder');
Route::post('video/move-to-trash', 'VideoController@moveToTrash');

Route::post('manga/trash', 'MangaController@trash');
Route::post('manga/read', 'MangaController@read');
Route::post('manga/group', 'MangaController@group');

Route::resource('/images', 'ImageController');
Route::post('v1/video/status/update', 'WorkspaceController@statusUpdate');
Route::post('v1/video/status/move', 'WorkspaceController@move');

Route::resource('/download-image', 'DownloadImageController');
Route::post('/download-image/url', 'DownloadImageController@downloadImage');
Route::post('/download-image/retry', 'DownloadImageController@retryDownload');
Route::post('/download-image/fill', 'DownloadImageController@fillDownload');
Route::post('/download-image/refresh-cover', 'DownloadImageController@refreshCover');
Route::post('/download-image/retry-all', 'DownloadImageController@retryAll');
Route::post('/download-image/delete', 'DownloadImageController@deleteDownload');

Route::resource('note', 'NoteController');
Route::post('note/add', 'NoteController@store');
Route::post('note/delete', 'NoteController@destroy');

Route::get('/download-tiktok/{videoId}', [TikTokController::class, 'download'])->name('tiktok.download');

Route::fallback(function(){
    if (!Auth::user()) {
        return redirect()->to('/login');
    }else{
        return redirect()->to('/home');
    }
});
Auth::routes();
