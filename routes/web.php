<?php


use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\EduwisataController;
use App\Http\Controllers\PerijinanControler;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rute-rute ini dikelola oleh RouteServiceProvider yang sudah termasuk 
| dalam grup "web" middleware.
|
*/

// Halaman utama
Route::get('/', [FrontendController::class, 'index']);

// Halaman kontak
Route::get('/contact', [ContactController::class, 'index']);
Route::post('/contact/send', [ContactController::class, 'store']);

// Middleware otentikasi untuk dashboard
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Dashboard utama
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    // Gallery
    Route::resource('/dashboard/gallery', GalleryController::class)->names('dashboard.gallery');
    Route::get('/dashboard/gallery/destroy/{id}', [GalleryController::class, 'destroy']);
    Route::get('/dashboard/gallery/edit/{id}', [GalleryController::class, 'edit']);
    Route::post('/dashboard/gallery/update', [GalleryController::class, 'update']);

    // Gallery video
    Route::resource('/dashboard/videos', VideoController::class)->names('dashboard.videos');
    Route::get('/dashboard/videos/destroy/{id}', [VideoController::class, 'destroy']);
    Route::get('/dashboard/videos/edit/{id}', [VideoController::class, 'edit']);
    Route::post('/dashboard/videos/update', [VideoController::class, 'update']);

    // Blog
    Route::resource('/dashboard/blog', BlogController::class)->names('dashboard.blog');
    Route::get('/dashboard/blog/destroy/{id}', [BlogController::class, 'destroy']);

    //contact 
    Route::get('/dashboard/contact/messages', [ContactController::class, 'messages'])->name('dashboard.contact.messages');
    Route::get('/dashboard/contact/messages/{contact}', [ContactController::class, 'showMessage'])->name('dashboard.contact.show');
    Route::delete('/dashboard/contact/messages/{contact}', [ContactController::class, 'destroyMessage'])->name('dashboard.contact.destroy');

    // Produk (sebelumnya Portfolio)
    Route::resource('/dashboard/product', ProductController::class)->names('dashboard.product');
    Route::get('/dashboard/product/destroy/{id}', [ProductController::class, 'destroy']);
    Route::get('/dashboard/product/edit/{id}', [ProductController::class, 'edit']);

    // Prestasi (sebelumnya Misi)
    Route::resource('/dashboard/prestasi', PrestasiController::class)->names('dashboard.prestasi');
    Route::get('/dashboard/prestasi/edit/{id}', [PrestasiController::class, 'edit']);
    Route::post('/dashboard/prestasi/update', [PrestasiController::class, 'update']);

    // Eduwisata dengan fitur jadwal
    Route::resource('/dashboard/eduwisata', EduwisataController::class)
    ->names('dashboard.eduwisata')
    ->parameters(['eduwisata' => 'eduwisata']);

    // Menampilkan halaman daftar jadwal
    Route::get('/dashboard/eduwisata/schedule/{eduwisata}', [EduwisataController::class, 'schedule'])
        ->name('dashboard.eduwisata.schedule');

    // Menyimpan jadwal baru
    Route::post('/dashboard/eduwisata/schedule/store', [EduwisataController::class, 'storeSchedule'])
        ->name('dashboard.eduwisata.storeSchedule');

    // Menghapus jadwal
    Route::delete('/dashboard/eduwisata/schedule/destroy/{schedule}', [EduwisataController::class, 'destroySchedule'])
        ->name('dashboard.eduwisata.destroySchedule');

    Route::get('/dashboard/orders', [OrderController::class, 'index'])->name('dashboard.orders.index');
    Route::put('/dashboard/orders/{order}', [OrderController::class, 'update'])->name('order.update');
    Route::get('/dashboard/orders/export', [OrderController::class, 'exportManual'])->name('orders.export');
});

// Frontend pages
// Frontend pages
Route::get('gallery', [GalleryController::class, 'index_fr'])->name('gallery');
Route::get('gallery/videos', [VideoController::class, 'index_fr'])->name('videos');
Route::get('/blog', [BlogController::class, 'index_fr'])->name('blog');
Route::get('/blog/{blog:title}', [BlogController::class, 'show_fr'])->name('blog.show_fr');
Route::get('perijinan', [PerijinanControler::class,'index_fr'])->name('perijinan');
Route::get('product', [ProductController::class, 'index_fr'])->name('product.index_fr');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
Route::get('profile', [PrestasiController::class, 'index_fr'])->name('profile');
Route::get('eduwisata', [EduwisataController::class, 'index_fr'])->name('eduwisata');
Route::get('eduwisata/schedule', [EduwisataController::class, 'schedule_fr'])->name('eduwisata.schedule');
Route::get('/eduwisata/{eduwisata}/schedule', [EduwisataController::class, 'scheduleDetail'])->name('eduwisata.schedule.detail');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/riwayat/produk/{telepon}', [OrderController::class, 'riwayatProduk'])->name('riwayat.produk');
Route::get('/riwayat/eduwisata/{telepon}', [OrderController::class, 'riwayatEduwisata'])->name('riwayat.eduwisata');
Route::get('/logout-riwayat', function () {
    Session::forget('telepon');
    return redirect('/')->with('success', 'Anda berhasil keluar dari riwayat.');
})->name('logout.riwayat');
Route::view('/login-wa', 'auth.login_wa')->name('login.wa');
Route::post('/login-wa', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'telepon' => 'required|regex:/^[0-9]{10,15}$/'
    ]);

    session(['telepon' => $request->telepon]);
    return redirect('/')->with('success', 'Login berhasil!');
})->name('login.wa.submit');
