<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\SitemapController;

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

// 语言切换路由（保持向后兼容）
Route::get('/locale/{locale}', [App\Http\Controllers\LocaleController::class, 'switch'])->name('locale.switch');

// 英文路由（无语言前缀）
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::prefix('jobs')->group(function () {
    Route::get('/', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/p/{page}', [JobController::class, 'index'])->name('jobs.page');
    Route::get('/{slug}', [JobController::class, 'show'])->name('jobs.show');
});
Route::get('/companies', [JobController::class, 'companies'])->name('companies.index');
Route::get('/companies/p/{page}', [JobController::class, 'companies'])->name('companies.page');
Route::get('/companies/{slug}', [JobController::class, 'company'])->name('companies.show');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// 多语言路由组（排除英文，因为英文使用无前缀路由）
Route::prefix('{locale}')->where(['locale' => 'zh|ko|ja|ru|vi'])->group(function () {
    
    // 首页
    Route::get('/', [HomeController::class, 'index'])->name('home.locale');
    
    // 职位相关路由
    Route::prefix('jobs')->group(function () {
        Route::get('/', [JobController::class, 'index'])->name('jobs.index.locale');
        Route::get('/p/{page}', [JobController::class, 'index'])->name('jobs.page.locale');
        Route::get('/{slug}', [JobController::class, 'show'])->name('jobs.show.locale');
    });
    
    // 公司相关路由
    Route::get('/companies', [JobController::class, 'companies'])->name('companies.index.locale');
    Route::get('/companies/p/{page}', [JobController::class, 'companies'])->name('companies.page.locale');
    Route::get('/companies/{slug}', [JobController::class, 'company'])->name('companies.show.locale');
    
    // 静态页面
    Route::get('/about', [HomeController::class, 'about'])->name('about.locale');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact.locale');
});

// SEO 相关路由
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', function () {
    return response("User-agent: *\nDisallow: /admin\nSitemap: " . url('/sitemap.xml'))
        ->header('Content-Type', 'text/plain');
})->name('robots');