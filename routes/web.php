<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\{HomeController, MemoryController, BlogController, NewsController};
use App\Http\Controllers\Admin;

// PUBLIC
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('memory/{slug}')->name('memory.')->group(function () {
    Route::get('/',        [MemoryController::class, 'show'])       ->name('show');
    Route::get('/unlock',  [MemoryController::class, 'showUnlock']) ->name('unlock');
    Route::post('/unlock', [MemoryController::class, 'unlock'])     ->name('unlock.post');
});

Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/',                [BlogController::class, 'index'])   ->name('index');
    Route::get('category/{slug}', [BlogController::class, 'category'])->name('category');
    Route::get('{slug}',          [BlogController::class, 'show'])    ->name('show');
});

Route::prefix('news')->name('news.')->group(function () {
    Route::get('/',      [NewsController::class, 'index'])->name('index');
    Route::get('{slug}', [NewsController::class, 'show']) ->name('show');
});

// ADMIN
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', Admin\CategoryController::class);

    Route::resource('memories', Admin\MemoryController::class);
    Route::patch('memories/{memory}/publish',       [Admin\MemoryController::class, 'togglePublish']) ->name('memories.publish');
    Route::post('memories/{memory}/images',         [Admin\ImageController::class,  'store'])         ->name('memories.images.store');
    Route::delete('images/{image}',                 [Admin\ImageController::class,  'destroy'])        ->name('images.destroy');
    Route::post('memories/{memory}/sections',       [Admin\SectionController::class,'store'])          ->name('memories.sections.store');
    Route::put('sections/{section}',                [Admin\SectionController::class,'update'])         ->name('sections.update');
    Route::delete('sections/{section}',             [Admin\SectionController::class,'destroy'])        ->name('sections.destroy');
    Route::post('memories/{memory}/sections/sort',  [Admin\SectionController::class,'sort'])           ->name('memories.sections.sort');

    Route::resource('blog', Admin\PostController::class)->parameters(['blog'=>'post']);
    Route::patch('blog/{post}/publish', [Admin\PostController::class, 'togglePublish'])->name('blog.publish');

    Route::resource('news', Admin\NewsController::class)->parameters(['news'=>'post']);
    Route::patch('news/{post}/publish', [Admin\NewsController::class, 'togglePublish'])->name('news.publish');
});

require __DIR__.'/auth.php';
