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

Auth::routes();


Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/about', function () {
    return view('pages.about');
});

Route::get('/blog', function () {
    return view('pages.blog');
});

Route::get('/blog/{id}', function ($id) {
    return view('pages.blog-details', ['id' => $id]);
})->where('id', '[0-9]+'); // ID блога должен быть числом

Route::get('/contact', function () {
    return view('pages.contact');
});


// Админка с отдельным шаблоном
Route::middleware(['auth'])->group(function () {
    Route::get('/backend', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/backend/contacts', [ContactController::class, 'index'])->name('admin.contacts');
});

// Маршрут для обработки формы
Route::post('/contact-submit', function (Request $request) {
    try {
        $data = $request->validate([
            'full_name'       => 'required|string|max:255',
            'company_name'    => 'nullable|string|max:255',
            'registration_id' => 'required|string|max:255',
            'country'         => 'required|string|max:255',
            'email'           => 'required|email|max:255',
            'phone'           => 'required|string|max:50',
            'plan'            => 'required|string|max:50',
            'total_price'     => 'required|numeric',
        ]);

        \Log::info('Validated Data:', $data);

        // Сохраняем заявку
        $order = Order::create([
            'full_name'       => $data['full_name'],
            'company_name'    => $data['company_name'] ?? null,
            'registration_id' => $data['registration_id'],
            'country'         => $data['country'],
            'email'           => $data['email'],
            'phone'           => $data['phone'],
            'plan'            => $data['plan'],
            'total_price'     => $data['total_price'],
            'payment_status'  => 'pending',
        ]);

        \Log::info('Order Created:', ['order_id' => $order->id]);

        return response()->json([
            'success' => true,
            'message' => 'Order has been saved!',
            'redirect_url' => url('/thank-you-for-the-lei-application/?order=' . $order->id)
        ]);
    } catch (\Exception $e) {
        \Log::error('Error in /contact-submit:', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Something went wrong!'], 500);
    }
});



Route::middleware(['auth'])->group(function () {
    Route::get('/backend/contacts', [ContactController::class, 'index'])->name('admin.contacts');
    Route::delete('/backend/contacts/{id}', [ContactController::class, 'destroy'])->name('admin.contacts.destroy');
    Route::get('/backend/contacts/export/csv', [ContactController::class, 'exportCsv'])->name('admin.contacts.export.csv');
    Route::get('/backend/contacts/export/xlsx', [ContactController::class, 'exportXlsx'])->name('admin.contacts.export.xlsx');
});


// Фронт-блог
Route::get('/blog', [FrontBlogController::class, 'blogList'])->name('blog.index');
Route::get('/blog/{slug}', [FrontBlogController::class, 'show'])->name('blog.show');


// Админка для управления блогами
Route::prefix('backend')->middleware(['auth'])->group(function () {
    Route::get('/blogs', [AdminBlogController::class, 'index'])->name('admin.blogs');
    Route::get('/blogs/create', [AdminBlogController::class, 'create'])->name('admin.blogs.create');
    Route::post('/blogs/store', [AdminBlogController::class, 'store'])->name('admin.blogs.store');
    Route::get('/blogs/edit/{id}', [AdminBlogController::class, 'edit'])->name('admin.blogs.edit');
    Route::post('/blogs/update/{id}', [AdminBlogController::class, 'update'])->name('admin.blogs.update');
    Route::delete('/blogs/delete/{id}', [AdminBlogController::class, 'destroy'])->name('admin.blogs.destroy');
    Route::post('/blogs/status/{id}', [AdminBlogController::class, 'toggleStatus'])->name('admin.blogs.status');
});



Route::post('/contact-submit', [OrderController::class, 'submit'])->name('order.submit');

Route::get('/thank-you-for-the-lei-application', [OrderController::class, 'show'])->name('order.show');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::post('/orders/{id}/update-payment', [AdminController::class, 'updatePaymentStatus'])->name('admin.orders.updatePaymentStatus');
});

