<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TagController;

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

// お問い合わせフォームのルート
Route::get('/', [ContactController::class, 'index'])->name('contact.index');

// お問い合せフォーム確認のルート
Route::post('/contacts/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');

//サンクスページのルート
Route::post('/contacts', [ContactController::class, 'store'])->name('contact.store');

// 管理者登録ページのルート
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.index')->middleware(['auth', 'verified']); 

// 管理画面のルート
Route::get('/admin', [AdminController::class, 'admin'])->name('admin.index')->middleware(['auth', 'verified']);

// お問い合わせ詳細ページのルート
Route::get('/admin/contacts/{contact}', [AdminController::class, 'show'])->name('admin.contacts.show')->middleware(['auth', 'verified']);

// お問い合わせ削除のルート
Route::delete('/admin/contacts/{contact}', [AdminController::class, 'destroy'])->name('admin.contacts.destroy')->middleware(['auth', 'verified']);

// お問い合せ検索のルート
Route::get('/admin', [AdminController::class, 'index'])->name('admin.contacts.index')->middleware(['auth', 'verified']);

// タグ追加のルート
Route::post('/admin/tags', [TagController::class, 'store'])->name('tags.store')->middleware(['auth', 'verified']);

// タグ削除のルート
Route::delete('/admin/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy')->middleware(['auth', 'verified']);

// タグ編集ページのルート
Route::get('/admin/tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit')->middleware(['auth', 'verified']);

// タグ更新のルート
Route::put('/admin/tags/{tag}', [TagController::class, 'update'])->name('tags.update')->middleware(['auth', 'verified']);
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index')->middleware(['auth', 'verified']);

// エクスポート機能
Route::get('/contacts/export', [ContactController::class, 'export'])
    ->name('contacts.export');
