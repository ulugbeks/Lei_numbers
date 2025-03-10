<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BlogController as FrontBlogController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\PageController;

Auth::routes();


Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/news', function () {
    return view('pages.blog');
});

Route::get('/news/{id}', function ($id) {
    return view('pages.blog-details', ['id' => $id]);
})->where('id', '[0-9]+'); 

Route::get('/contact', function () {
    return view('pages.contact');
});

Route::get('/about-lei', function () {
    return view('pages.about-lei');
});

Route::get('/registration-lei', function () {
    return view('pages.registration-lei');
});


// Админка с отдельным шаблоном
Route::middleware(['auth'])->group(function () {
    Route::get('/backend', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/backend/contacts', [ContactController::class, 'index'])->name('admin.contacts');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/backend/contacts', [ContactController::class, 'index'])->name('admin.contacts');
    Route::delete('/backend/contacts/{id}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');
    Route::get('/backend/contacts/export/csv', [ContactController::class, 'exportCsv'])->name('admin.contacts.export.csv');
    Route::get('/backend/contacts/export/xlsx', [ContactController::class, 'exportXlsx'])->name('admin.contacts.export.xlsx');
});


// Фронт-блог
Route::get('/news', [FrontBlogController::class, 'blogList'])->name('blog.index');
Route::get('/news/{slug}', [FrontBlogController::class, 'show'])->name('blog.show');


// Админка для управления блогами
Route::prefix('backend')->middleware(['auth'])->group(function () {
    Route::get('/blogs', [AdminBlogController::class, 'index'])->name('admin.blogs.index'); // изменено name
    Route::get('/blogs/create', [AdminBlogController::class, 'create'])->name('admin.blogs.create');
    Route::post('/blogs/store', [AdminBlogController::class, 'store'])->name('admin.blogs.store');
    Route::get('/blogs/edit/{id}', [AdminBlogController::class, 'edit'])->name('admin.blogs.edit');
    Route::post('/blogs/update/{id}', [AdminBlogController::class, 'update'])->name('admin.blogs.update');
    Route::delete('/blogs/delete/{id}', [AdminBlogController::class, 'destroy'])->name('admin.blogs.destroy');
    Route::post('/blogs/status/{id}', [AdminBlogController::class, 'toggleStatus'])->name('admin.blogs.status');
    Route::post('/blogs/upload', [AdminBlogController::class, 'upload'])->name('admin.blogs.upload');
    Route::get('/pages', [PageController::class, 'index'])->name('admin.pages.index');
    Route::get('/pages/{id}/edit', [PageController::class, 'edit'])->name('admin.pages.edit');
    Route::put('/pages/{id}', [PageController::class, 'update'])->name('admin.pages.update');
    Route::post('/pages/upload-image', [PageController::class, 'uploadImage'])->name('admin.pages.upload-image');
});



Route::post('/contact-submit', [ContactController::class, 'store'])->name('contact.store');
Route::post('/renew-submit', [ContactController::class, 'renew'])->name('contact.renew');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/contacts', [ContactController::class, 'index'])->name('admin.contacts');
    Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('admin.contact.show');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('admin.contact.destroy');
    Route::get('/contacts/export', [ContactController::class, 'export'])->name('admin.contacts.export');
    Route::get('/payments', [AdminController::class, 'paymentReport'])->name('admin.payments');
    Route::get('/payments/export', [AdminController::class, 'exportPayments'])->name('admin.payments.export');
});

Route::get('/payment/{id}', [PaymentController::class, 'show'])->name('payment.show');
Route::get('/payment/success/{paymentIntent}', [PaymentController::class, 'success'])->name('payment.success');
