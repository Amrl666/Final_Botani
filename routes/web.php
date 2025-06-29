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
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\DeliveryController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Rute-rute ini dikelola oleh RouteServiceProvider yang sudah termasuk 
| dalam grup "web" middleware.
|
*/

// Add Fortify logout route for admin
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware(['web', 'auth'])
    ->name('logout');

// Halaman utama
Route::get('/', [FrontendController::class, 'index']);

// Halaman kontak
Route::get('/contact', [ContactController::class, 'index']);
Route::post('/contact/send', [ContactController::class, 'store']);

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::get('/cart/count-customer', [CartController::class, 'getCartCountForCustomer'])->name('cart.count.customer');

// Checkout route
Route::get('/checkout', [OrderController::class, 'checkoutForm'])->name('checkout.form');
Route::post('/checkout', [OrderController::class, 'checkoutFromCart'])->name('checkout.process');

// Public delivery tracking
Route::get('/track/{trackingNumber}', [DeliveryController::class, 'track'])->name('delivery.track');

// Middleware otentikasi untuk dashboard
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Dashboard utama
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    // Gallery
    Route::resource('/dashboard/gallery', GalleryController::class)->names('dashboard.gallery');
    
    // Product management
    Route::resource('/dashboard/products', ProductController::class)->names('dashboard.products');
    
    // Video management
    Route::resource('/dashboard/videos', VideoController::class)->names('dashboard.videos');

    // Blog
    Route::resource('/dashboard/blog', BlogController::class)->names('dashboard.blog');
    Route::get('/dashboard/blog/destroy/{id}', [BlogController::class, 'destroy']);

    //contact 
    Route::get('/dashboard/contact/messages', [ContactController::class, 'messages'])->name('dashboard.contact.messages');
    Route::get('/dashboard/contact/{contact}', [ContactController::class, 'showMessage'])->name('dashboard.contact.show');
    Route::delete('/dashboard/contact/{contact}', [ContactController::class, 'destroyMessage'])->name('dashboard.contact.destroy');

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

    // Dashboard analytics
    Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('dashboard.analytics');
    Route::get('/dashboard/reports', [DashboardController::class, 'reports'])->name('dashboard.reports');
    
    // Payment management
    Route::get('/dashboard/payments', [PaymentController::class, 'index'])->name('dashboard.payments.index');
    Route::get('/dashboard/payments/{payment}', [PaymentController::class, 'showAdmin'])->name('dashboard.payments.show');
    Route::patch('/dashboard/payments/{payment}/verify', [PaymentController::class, 'verify'])->name('dashboard.payments.verify');
    Route::patch('/dashboard/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('dashboard.payments.reject');
    
    // Customer management
    Route::get('/dashboard/customers', [CustomerController::class, 'index'])->name('dashboard.customers');
    Route::get('/dashboard/customers/{customer}', [CustomerController::class, 'show'])->name('dashboard.customers.show');
    
    // Notification management
    Route::get('/dashboard/notifications', [NotificationController::class, 'index'])->name('dashboard.notifications.index');
    Route::patch('/dashboard/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('dashboard.notifications.mark-read');
    Route::post('/dashboard/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('dashboard.notifications.mark-all-read');
    Route::delete('/dashboard/notifications/{notification}', [NotificationController::class, 'destroy'])->name('dashboard.notifications.destroy');
    Route::delete('/dashboard/notifications', [NotificationController::class, 'clearAll'])->name('dashboard.notifications.clear-all');
    Route::post('/dashboard/notifications/send', [NotificationController::class, 'sendNotification'])->name('dashboard.notifications.send');
    Route::post('/dashboard/notifications/send-promo', [NotificationController::class, 'sendPromoNotification'])->name('dashboard.notifications.send-promo');

    // Keep the old routes for backward compatibility
    Route::get('/dashboard/notification', [NotificationController::class, 'index'])->name('dashboard.notification.index');
    Route::patch('/dashboard/notification/{notification}/read', [NotificationController::class, 'markAsRead'])->name('dashboard.notification.read');
    Route::post('/dashboard/notification/send', [NotificationController::class, 'sendNotification'])->name('dashboard.notification.send');

    // Stock management routes
    Route::get('/dashboard/stock', [StockController::class, 'index'])->name('dashboard.stock.index');
    Route::get('/dashboard/stock/{product}/history', [StockController::class, 'history'])->name('dashboard.stock.history');
    Route::post('/dashboard/stock/{product}/adjust', [StockController::class, 'adjust'])->name('dashboard.stock.adjust');
    Route::post('/dashboard/stock/bulk-adjust', [StockController::class, 'bulkAdjust'])->name('dashboard.stock.bulk-adjust');
    Route::get('/dashboard/stock/export', [StockController::class, 'export'])->name('dashboard.stock.export');

    // Delivery management routes
    Route::get('/dashboard/delivery', [DeliveryController::class, 'index'])->name('dashboard.delivery.index');
    Route::get('/dashboard/delivery/create/{order}', [DeliveryController::class, 'create'])->name('dashboard.delivery.create');
    Route::post('/dashboard/delivery/{order}', [DeliveryController::class, 'store'])->name('dashboard.delivery.store');
    Route::get('/dashboard/delivery/{delivery}', [DeliveryController::class, 'show'])->name('dashboard.delivery.show');
    Route::patch('/dashboard/delivery/{delivery}/status', [DeliveryController::class, 'updateStatus'])->name('dashboard.delivery.update-status');
});

// Frontend pages
Route::get('gallery', [GalleryController::class, 'index_fr'])->name('gallery');
Route::get('gallery/videos', [VideoController::class, 'index_fr'])->name('videos');
Route::get('/blog', [BlogController::class, 'index_fr'])->name('blog');
Route::get('/blog/{blog:title}', [BlogController::class, 'show_fr'])->name('blog.show_fr');
Route::get('perijinan', [PerijinanControler::class,'index_fr'])->name('perijinan');
Route::get('product', [ProductController::class, 'index_fr'])->name('product.index_fr');
Route::get('/product/{product}', [App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
Route::get('profile', [PrestasiController::class, 'index_fr'])->name('profile');
Route::get('eduwisata', [EduwisataController::class, 'index_fr'])->name('eduwisata');
Route::get('eduwisata/schedule', [EduwisataController::class, 'schedule_fr'])->name('eduwisata.schedule');
Route::get('/eduwisata/{eduwisata}/schedule', [EduwisataController::class, 'scheduleDetail'])->name('eduwisata.schedule.detail');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::post('/order/checkout-cart', [OrderController::class, 'checkoutFromCart'])->name('order.checkout-cart');
Route::get('/riwayat/produk', [OrderController::class, 'riwayatProduk'])->name('riwayat.produk');
Route::get('/riwayat/eduwisata', [OrderController::class, 'riwayatEduwisata'])->name('riwayat.eduwisata');
Route::get('/logout-riwayat', function () {
    Session::forget('customer_phone');
    Session::forget('customer_id');
    return redirect('/')->with('success', 'Anda berhasil keluar dari riwayat.');
})->name('logout.riwayat');
Route::view('/login-wa', 'auth.login_wa')->name('login.wa');
Route::post('/login-wa', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'telepon' => 'required|regex:/^[0-9]{10,15}$/'
    ]);

    // Cek apakah nomor WA pernah digunakan untuk pemesanan
    $exists = Order::where('telepon', $request->telepon)->exists();

    if (!$exists) {
        return back()->withErrors(['telepon' => 'Nomor ini belum pernah digunakan untuk pemesanan.']);
    }

    session(['customer_phone' => $request->telepon]);
    return redirect('/')->with('success', 'Login berhasil!');
})->name('login.wa.submit');

Route::get('/order-now/{product}', [App\Http\Controllers\OrderController::class, 'orderNowForm'])->name('order.now.form');

// Payment routes
Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/payment/{order}/process', [PaymentController::class, 'process'])->name('payment.process');
Route::get('/payment/{order}/success', [PaymentController::class, 'success'])->name('payment.success');

// Customer routes
Route::get('/register', [CustomerController::class, 'showRegistrationForm'])->name('customer.register');
Route::post('/register', [CustomerController::class, 'register']);
Route::get('/customer/login', [CustomerController::class, 'showLoginForm'])->name('customer.login');
Route::post('/customer/login', [CustomerController::class, 'login']);
Route::post('/customer/logout', [CustomerController::class, 'logout'])->name('customer.logout');

// Customer dashboard (protected)
Route::middleware(['auth.customer'])->group(function () {
    Route::get('/profile', [CustomerController::class, 'profile'])->name('customer.profile');
    Route::post('/profile/update', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
    Route::get('/orders', [CustomerController::class, 'orders'])->name('customer.orders');
    Route::get('/customer/wishlist', [CustomerController::class, 'wishlist'])->name('customer.wishlist');
    Route::post('/customer/wishlist/{product}', [CustomerController::class, 'addToWishlist'])->name('customer.wishlist.add');
    Route::delete('/customer/wishlist/{product}', [CustomerController::class, 'removeFromWishlist'])->name('customer.wishlist.remove');
    
    // Customer riwayat pemesanan
    Route::get('/customer/riwayat/produk', [CustomerController::class, 'riwayatProduk'])->name('customer.riwayat.produk');
    Route::get('/customer/riwayat/eduwisata', [CustomerController::class, 'riwayatEduwisata'])->name('customer.riwayat.eduwisata');
    
    // Shipping addresses management
    Route::resource('addresses', ShippingAddressController::class)->names('customer.addresses');
    Route::post('addresses/{address}/set-default', [ShippingAddressController::class, 'setDefault'])->name('customer.addresses.set-default');
    
    // Customer deliveries
    Route::get('deliveries', [DeliveryController::class, 'customerDeliveries'])->name('customer.deliveries');
});

// Wishlist routes (session-based)
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::delete('/wishlist/{product}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::delete('/wishlist', [WishlistController::class, 'clear'])->name('wishlist.clear');

// Debug route untuk memeriksa wishlist (hapus setelah selesai debugging)
Route::get('/debug/wishlist', function() {
    if (auth()->guard('customer')->check()) {
        $customer = auth()->guard('customer')->user();
        $wishlist = $customer->wishlist;
        dd([
            'customer_id' => $customer->id,
            'wishlist_count' => $wishlist->count(),
            'wishlist_products' => $wishlist->pluck('name'),
            'wishlists_table' => \DB::table('wishlists')->where('customer_id', $customer->id)->get()
        ]);
    }
    return 'Not logged in';
});

// Debug route untuk testing wishlist dengan query langsung
Route::get('/debug/wishlist2', function() {
    if (auth()->guard('customer')->check()) {
        $customer = auth()->guard('customer')->user();
        
        $wishlistData = \DB::table('wishlists')->where('customer_id', $customer->id)->get();
        $wishlist = \App\Models\Product::whereHas('customers', function($query) use ($customer) {
            $query->where('customers.id', $customer->id);
        })->get();
        
        dd([
            'customer_id' => $customer->id,
            'wishlist_data_count' => $wishlistData->count(),
            'wishlist_data' => $wishlistData,
            'wishlist_products_count' => $wishlist->count(),
            'wishlist_products' => $wishlist->pluck('name')
        ]);
    }
    return 'Not logged in';
});

// Route untuk testing wishlist view
Route::get('/test/wishlist', function() {
    if (auth()->guard('customer')->check()) {
        $customer = auth()->guard('customer')->user();
        
        $wishlist = \App\Models\Product::whereHas('customers', function($query) use ($customer) {
            $query->where('customers.id', $customer->id);
        })->paginate(12);
        
        return view('Frontend.customer.wishlist', compact('wishlist'));
    }
    return redirect()->route('customer.login');
})->name('test.wishlist');

// Route untuk testing wishlist view sederhana
Route::get('/test/wishlist-simple', function() {
    if (auth()->guard('customer')->check()) {
        $customer = auth()->guard('customer')->user();
        
        $wishlist = \App\Models\Product::whereHas('customers', function($query) use ($customer) {
            $query->where('customers.id', $customer->id);
        })->get();
        
        return view('Frontend.customer.wishlist_simple', compact('wishlist'));
    }
    return 'Not logged in';
})->name('test.wishlist.simple');

// Route test untuk profil customer
Route::get('/test/profile', function() {
    if (auth()->guard('customer')->check()) {
        $customer = auth()->guard('customer')->user();
        return view('Frontend.customer.profile', compact('customer'));
    }
    return 'Not logged in';
})->name('test.profile');
    