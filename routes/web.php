<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
//use App\Http\Controllers\WebhookController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BlogController as FrontBlogController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\GleifController; 

Auth::routes();

// Front-end dynamic page routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/about-lei', [PageController::class, 'aboutLei'])->name('about-lei');
Route::get('/registration-lei', [PageController::class, 'registrationLei'])->name('registration-lei');
Route::get('/cookies', [PageController::class, 'cookies'])->name('cookies');
Route::get('/terms-and-conditions', [PageController::class, 'terms'])->name('terms-and-conditions');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy-policy');

// News routes
Route::get('/news', [FrontBlogController::class, 'blogList'])->name('blog.index');
Route::get('/news/{slug}', [FrontBlogController::class, 'show'])->name('blog.show');

// GLEIF API routes - Add these new routes
// In your routes/web.php or routes/api.php file
Route::get('/gleif/search', 'GleifController@searchByName');
Route::get('/api/gleif/search-name', [GleifController::class, 'searchByName'])->name('gleif.search.name');
Route::get('/api/gleif/lei-details', [GleifController::class, 'getLeiDetails'])->name('gleif.lei.details');
Route::get('/api/gleif/search-registration', [GleifController::class, 'searchByRegistrationId'])->name('gleif.search.registration');



Route::post('/register-submit', [GleifController::class, 'processRegistration'])->name('register.submit');
Route::post('/renew-submit', [GleifController::class, 'processRenewal'])->name('renew.submit');
Route::post('/transfer-submit', [GleifController::class, 'processTransfer'])->name('transfer.submit');
Route::post('/bulk-submit', [GleifController::class, 'processBulkRegistration'])->name('bulk.submit');

// Confirmation and processing pages for GLEIF - Add these new routes
Route::get('/transfer/confirmation', function() {
    return view('lei.transfer-confirmation');
})->name('transfer.confirmation');

Route::get('/bulk/confirmation', function() {
    return view('lei.bulk-confirmation');
})->name('bulk.confirmation');

Route::get('/renew', function() {
    return view('lei.renew', ['lei' => request('lei')]);
})->name('renew.show');

// Custom pages route (for pages created through admin)
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show')
    ->where('slug', '[a-z0-9\-]+')
    ->where('slug', '!=', 'admin')
    ->where('slug', '!=', 'backend')
    ->where('slug', '!=', 'login')
    ->where('slug', '!=', 'register')
    ->where('slug', '!=', 'news')
    ->where('slug', '!=', 'renew') // Add this exclusion for the new renew route
    ->where('slug', '!=', 'transfer') // Add this exclusion for the new transfer route
    ->where('slug', '!=', 'bulk'); // Add this exclusion for the new bulk route

// Админка с отдельным шаблоном
Route::middleware(['auth'])->group(function () {
    Route::get('/backend', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/backend/contacts', [ContactController::class, 'index'])->name('admin.contacts');
});

// Admin contacts routes
Route::middleware(['auth'])->group(function () {
    Route::get('/backend/contacts', [ContactController::class, 'index'])->name('admin.contacts');
    Route::delete('/backend/contacts/{id}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');
    Route::get('/backend/contacts/export/csv', [ContactController::class, 'exportCsv'])->name('admin.contacts.export.csv');
    Route::get('/backend/contacts/export/xlsx', [ContactController::class, 'exportXlsx'])->name('admin.contacts.export.xlsx');
});

// Admin pages management with correct class name
Route::prefix('backend')->middleware(['auth'])->group(function () {
    // Blog management routes
    Route::get('/blogs', [AdminBlogController::class, 'index'])->name('admin.blogs.index');
    Route::get('/blogs/create', [AdminBlogController::class, 'create'])->name('admin.blogs.create');
    Route::post('/blogs/store', [AdminBlogController::class, 'store'])->name('admin.blogs.store');
    Route::get('/blogs/edit/{id}', [AdminBlogController::class, 'edit'])->name('admin.blogs.edit');
    Route::post('/blogs/update/{id}', [AdminBlogController::class, 'update'])->name('admin.blogs.update');
    Route::delete('/blogs/delete/{id}', [AdminBlogController::class, 'destroy'])->name('admin.blogs.destroy');
    Route::post('/blogs/status/{id}', [AdminBlogController::class, 'toggleStatus'])->name('admin.blogs.status');
    Route::post('/blogs/upload', [AdminBlogController::class, 'upload'])->name('admin.blogs.upload');
    
    // Pages management routes - using the AdminPageController alias
    Route::get('/pages', [AdminPageController::class, 'index'])->name('admin.pages.index');
    Route::get('/pages/create', [AdminPageController::class, 'create'])->name('admin.pages.create');
    Route::post('/pages', [AdminPageController::class, 'store'])->name('admin.pages.store');
    Route::get('/pages/{id}/edit', [AdminPageController::class, 'edit'])->name('admin.pages.edit');
    Route::put('/pages/{id}', [AdminPageController::class, 'update'])->name('admin.pages.update');
    Route::delete('/pages/{id}', [AdminPageController::class, 'destroy'])->name('admin.pages.destroy');
    Route::post('/pages/upload-image', [AdminPageController::class, 'uploadImage'])->name('admin.pages.upload-image');
    
    // Menu management routes
    Route::prefix('menus')->name('admin.menus.')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::get('/create', [MenuController::class, 'create'])->name('create');
        Route::post('/', [MenuController::class, 'store'])->name('store');
        Route::get('/{menu}', [MenuController::class, 'show'])->name('show');
        Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('edit');
        Route::put('/{menu}', [MenuController::class, 'update'])->name('update');
        Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy');
        
        // Menu items management
        Route::get('/{menu}/items', [MenuController::class, 'items'])->name('items');
        Route::post('/{menu}/items', [MenuController::class, 'storeItem'])->name('items.store');
        Route::put('/items/{menuItem}', [MenuController::class, 'updateItem'])->name('items.update');
        Route::delete('/items/{menuItem}', [MenuController::class, 'destroyItem'])->name('items.destroy');
        Route::post('/items/reorder', [MenuController::class, 'reorderItems'])->name('items.reorder');

        Route::match(['put', 'post'], '/items/{menuItem}', [MenuController::class, 'updateItem'])->name('items.update');
    });
    
    // GLEIF-related admin routes - Add these new routes for admin panel
    Route::get('/lei-transactions', [GleifController::class, 'adminTransactions'])->name('admin.lei.transactions');
    Route::get('/lei-transactions/export', [GleifController::class, 'exportTransactions'])->name('admin.lei.export');
});

// Contact form submission
Route::post('/contact-submit', [ContactController::class, 'store'])->name('contact.store');
//Route::post('/renew-submit', [ContactController::class, 'renew'])->name('contact.renew');
Route::post('/renew-submit', [GleifController::class, 'processRenewal'])->name('renew.submit');

// Admin routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/contacts', [ContactController::class, 'index'])->name('admin.contacts');
    Route::get('/contacts/{id}', [ContactController::class, 'show'])->name('admin.contact.show');
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('admin.contact.destroy');
    Route::get('/contacts/export', [ContactController::class, 'export'])->name('admin.contacts.export');
    Route::get('/payments', [AdminController::class, 'paymentReport'])->name('admin.payments');
    Route::get('/payments/export', [AdminController::class, 'exportPayments'])->name('admin.payments.export');
});

// Payment routes
Route::get('/payment/{id}', [PaymentController::class, 'show'])->name('payment.show');
Route::get('/payment/success/{paymentIntent}', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');
Route::post('/payment/create-intent', [PaymentController::class, 'createIntent'])->name('payment.create-intent');
Route::post('/webhook/stripe', [PaymentController::class, 'handleWebhook'])->name('webhook.stripe');


// Registration form submission route
Route::post('/register-submit', [GleifController::class, 'processRegistration'])->name('register.submit');

// This should come AFTER the POST route
Route::get('/register-submit', function() {
    return view('pages.form-info', [
        'message' => 'This URL is only for form submissions. Please use our registration form.'
    ]);
});




// User Authentication Routes (Custom)
Route::get('/login', [App\Http\Controllers\Auth\CustomLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\CustomLoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\CustomLoginController::class, 'logout'])->name('logout');

Route::get('/register', [App\Http\Controllers\Auth\CustomRegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\CustomRegisterController::class, 'register']);

// User Profile Routes
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('user.profile');
    Route::post('/profile/update', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/password/update', [App\Http\Controllers\UserController::class, 'updatePassword'])->name('user.password.update');
    Route::get('/lei/{id}/renew', [App\Http\Controllers\UserController::class, 'renewLei'])->name('user.lei.renew');
    Route::get('/lei/{id}/transfer', [App\Http\Controllers\UserController::class, 'transferLei'])->name('user.lei.transfer');
});

// AJAX validation routes for registration
Route::post('/check-email', [App\Http\Controllers\Auth\CustomRegisterController::class, 'checkEmail'])->name('check.email');
Route::post('/check-username', [App\Http\Controllers\Auth\CustomRegisterController::class, 'checkUsername'])->name('check.username');
