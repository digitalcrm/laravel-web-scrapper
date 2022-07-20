<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScrapController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SettingController;

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

Route::controller(ScrapController::class)->group(function () {
    Route::resource('scrapper', ScrapController::class)->only('index', 'create');
    Route::get('import/jobs', 'jobImport')->name('scrapper.import');
    Route::get('sites', 'jobsites')->name('scrapper.site');
});

Route::controller(ReportController::class)->group(function () {
    Route::get('reports', 'index')->name('reports');
    Route::get('stats', 'stats')->name('stats');
});

Route::get('companies', [CompanyController::class, 'index'])->name('company.index');
Route::get('peoples', [PeopleController::class, 'index'])->name('people.index');

Route::controller(SearchController::class)->group(function () {
    Route::get('search', 'searchForm')->name('search.form');
    Route::get('search/list', 'index')->name('search.list');
    Route::get('export-jobs', 'export')->name('export.jobs');
});

Route::get('settings/{value?}', [SettingController::class, 'index'])->name('settings');

require __DIR__ . '/auth.php';
