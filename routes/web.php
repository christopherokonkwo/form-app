<?php

use App\Http\Controllers\Dashboard\PostController;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\Dashboard\SearchController;
use App\Http\Controllers\Dashboard\StatsController;
use App\Http\Controllers\Dashboard\TagController;
use App\Http\Controllers\Dashboard\TopicController;
use App\Http\Controllers\Dashboard\UploadsController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ViewController;
use App\Http\Controllers\IncidentReportController;
use App\Http\Middleware\Admin;
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

Route::get('/', [IncidentReportController::class, 'create'])->name('home');
Route::post('/incident-report', [IncidentReportController::class, 'store'])->name('incident-report.store');

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::prefix('api')->group(function () {
        // Stats routes...
        Route::get('stats', StatsController::class);

        // Upload routes...
        Route::prefix('uploads')->group(function () {
            Route::post('/', [UploadsController::class, 'store']);
            Route::delete('/', [UploadsController::class, 'destroy']);
        });

        // Post routes...
        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index']);
            Route::get('create', [PostController::class, 'create']);
            Route::get('{id}', [PostController::class, 'show']);
            Route::get('{id}/stats', [PostController::class, 'stats']);
            Route::post('{id}', [PostController::class, 'store']);
            Route::delete('{id}', [PostController::class, 'destroy']);
        });

        // Report routes...
        Route::prefix('reports')->group(function () {
            Route::get('/', [ReportController::class, 'index']);
            Route::get('create', [ReportController::class, 'create']);
            Route::get('{id}', [ReportController::class, 'show']);
            Route::post('{id}', [ReportController::class, 'store']);
            Route::delete('{id}', [ReportController::class, 'destroy']);
        });
        // Tag routes...
        Route::prefix('tags')->middleware([Admin::class])->group(function () {
            Route::get('/', [TagController::class, 'index']);
            Route::get('create', [TagController::class, 'create']);
            Route::get('{id}', [TagController::class, 'show']);
            Route::get('{id}/posts', [TagController::class, 'posts']);
            Route::post('{id}', [TagController::class, 'store']);
            Route::delete('{id}', [TagController::class, 'destroy']);
        });

        // Topic routes...
        Route::prefix('topics')->middleware([Admin::class])->group(function () {
            Route::get('/', [TopicController::class, 'index']);
            Route::get('create', [TopicController::class, 'create']);
            Route::get('{id}', [TopicController::class, 'show']);
            Route::get('{id}/posts', [TopicController::class, 'posts']);
            Route::post('{id}', [TopicController::class, 'store']);
            Route::delete('{id}', [TopicController::class, 'destroy']);
        });

        // User routes...
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->middleware([Admin::class]);
            Route::get('create', [UserController::class, 'create'])->middleware([Admin::class]);
            Route::get('{id}', [UserController::class, 'show']);
            Route::get('{id}/posts', [UserController::class, 'posts']);
            Route::post('{id}', [UserController::class, 'store']);
            Route::delete('{id}', [UserController::class, 'destroy'])->middleware([Admin::class]);
        });

        // Search routes...
        Route::prefix('search')->group(function () {
            Route::get('posts', [SearchController::class, 'posts']);
            Route::get('tags', [SearchController::class, 'tags'])->middleware([Admin::class]);
            Route::get('topics', [SearchController::class, 'topics'])->middleware([Admin::class]);
            Route::get('users', [SearchController::class, 'users'])->middleware([Admin::class]);
        });
    });

    // Catch-all route...
    Route::get('/{view?}', ViewController::class)->where('view', '(.*)')->name('dashboard');
});

require __DIR__.'/auth.php';
