<?php

use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScrapController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('scrapper', ScrapController::class)->only('index');
Route::get('import/jobs', [ScrapController::class, 'jobImport'])->name('scrapper.import');

Route::get('reports', [ReportController::class, 'index'])->name('reports');

Route::get('search', [SearchController::class, 'searchForm'])->name('search.form');
Route::get('search/list', [SearchController::class, 'index'])->name('search.list');

Route::get('settings/{value?}', [SettingController::class, 'index'])->name('settings');

require __DIR__.'/auth.php';
