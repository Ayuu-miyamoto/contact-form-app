<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

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
    return redirect()->route('contact.index');
});

// 管理者登録ページのルート
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.index')->middleware(['auth', 'verified']); 

// お問い合わせフォームのルート
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');

//お問い合せフォーム確認のルート
Route::post('/contacts/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');

//サンクスページのルート
Route::post('/contacts', [ContactController::class, 'store'])->name('contact.store');
