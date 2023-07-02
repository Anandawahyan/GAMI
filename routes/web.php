<?php
use App\Http\Controllers\Admin_Dashboard_Controller;
use App\Http\Controllers\AlamatController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerBarangController;
use App\Http\Controllers\Executive_Dashboard_Controller;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', ['type_menu'=>'dashboard']);
})->middleware(['auth'])->name('dashboard');

// Route::get('/login/admin', function() {
//     return view('pages.admin.login');
// })->middleware('guest');

// Discount
Route::get('/discount', [CartController::class, 'getDiscounts']);

//Customer
Route::get('/', [CustomerBarangController::class, 'index']);
Route::get('/barang/{barang}', [CustomerBarangController::class, 'show'])->name('customer_barang.show');
Route::get('/barang', [CustomerBarangController::class, 'catalog_index'])->name('customer_barang.catalog');

// Invoices
Route::get('/user/invoices', function() {
    return view('pages.customer.invoices');
});
Route::get('user/invoices/{order}', [PaymentController::class, 'show'])->name('payment.show')->middleware(['auth']);
Route::post('user/invoices', [PaymentController::class, 'store'])->name('payment.store')->middleware(['auth']);
Route::put('user/invoices/{order}', [PaymentController::class, 'update_order_status'])->name('payment.update')->middleware(['auth']); 

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index')->middleware(['auth']);
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware(['auth']);

// Address
Route::get('/address', [CheckoutController::class, 'getAlamatUser'])->name('checkout.alamatUser')->middleware(['auth']);
Route::post('/address', [AlamatController::class, 'storeAlamatUser'])->name('alamat.store')->middleware(['auth']);
Route::get('/token', function() {
    echo csrf_token();
});

//Api Dashboard
Route::get('/admin/sales', [Admin_Dashboard_Controller::class, 'getSalesForChart']);
Route::get('/executive/chart', [Executive_Dashboard_Controller::class, 'get_chart_contents']);
Route::get('/executive/analysis/marketing', [Executive_Dashboard_Controller::class, 'get_marketing_analysis']);
Route::get('/executive/analysis/rfm', [Executive_Dashboard_Controller::class, 'get_rfm_analysis']);
Route::get('/executive/analysis/review', [Executive_Dashboard_Controller::class, 'get_review_analysis']);

Route::redirect('/admin','/admin/dashboard')->middleware(['admin']);

// Dashboard
Route::get('/executive/dashboard', [Executive_Dashboard_Controller::class, 'index']);
Route::get('/admin/dashboard', 'App\Http\Controllers\Admin_Dashboard_Controller@index')->name('dashboard.index');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{cart}', [CartController::class, 'store'])->name('cart.add');
Route::delete('/cart/{cart}', [CartController::class, 'delete'])->name('cart.delete');

//Resource
Route::resource('admin/barang', BarangController::class)->middleware(['admin']);

//Sampah
Route::post('admin/sampah/{barang}', [BarangController::class, 'to_trash'])->name('barang.to_trash');
Route::get('/admin/sampah', [BarangController::class, 'sampah_index'])->name('barang.sampah_index');
Route::delete('/admin/sampah', [BarangController::class, 'destroy_all'])->name('barang.destroy_all');
Route::post('/admin/sampah', [BarangController::class, 'restore_all'])->name('barang.restore_all');
Route::put('/admin/sampah/{barang}', [BarangController::class, 'to_restore'])->name('barang.to_restore');

//Order
Route::get('/admin/order', [OrderController::class, 'index'])->name('order.index');
Route::get('/admin/order/{order}', [OrderController::class, 'show'])->name('order.detail');
Route::put('/admin/order/{order}', [OrderController::class, 'update'])->name('order.update');

//Message
Route::get('/admin/ticket/{ticket}', [MessageController::class, 'index'])->name('ticket.index');
Route::post('/admin/ticket/{ticket}', [MessageController::class, 'store'])->name('ticket.create');
Route::put('/admin/ticket/{ticket}', [MessageController::class, 'setSolved'])->name('ticket.solved');

// Layout
Route::get('/layout-default-layout', function () {
    return view('pages.layout-default-layout', ['type_menu' => 'layout']);
});

// Blank Page
Route::get('/blank-page', function () {
    return view('pages.blank-page', ['type_menu' => '']);
});

// Bootstrap
Route::get('/bootstrap-alert', function () {
    return view('pages.bootstrap-alert', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-badge', function () {
    return view('pages.bootstrap-badge', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-breadcrumb', function () {
    return view('pages.bootstrap-breadcrumb', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-buttons', function () {
    return view('pages.bootstrap-buttons', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-card', function () {
    return view('pages.bootstrap-card', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-carousel', function () {
    return view('pages.bootstrap-carousel', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-collapse', function () {
    return view('pages.bootstrap-collapse', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-dropdown', function () {
    return view('pages.bootstrap-dropdown', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-form', function () {
    return view('pages.bootstrap-form', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-list-group', function () {
    return view('pages.bootstrap-list-group', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-media-object', function () {
    return view('pages.bootstrap-media-object', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-modal', function () {
    return view('pages.bootstrap-modal', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-nav', function () {
    return view('pages.bootstrap-nav', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-navbar', function () {
    return view('pages.bootstrap-navbar', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-pagination', function () {
    return view('pages.bootstrap-pagination', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-popover', function () {
    return view('pages.bootstrap-popover', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-progress', function () {
    return view('pages.bootstrap-progress', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-table', function () {
    return view('pages.bootstrap-table', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-tooltip', function () {
    return view('pages.bootstrap-tooltip', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-typography', function () {
    return view('pages.bootstrap-typography', ['type_menu' => 'bootstrap']);
});


// components
Route::get('/components-article', function () {
    return view('pages.components-article', ['type_menu' => 'components']);
});
Route::get('/components-avatar', function () {
    return view('pages.components-avatar', ['type_menu' => 'components']);
});
Route::get('/components-chat-box', function () {
    return view('pages.components-chat-box', ['type_menu' => 'components']);
});
Route::get('/components-empty-state', function () {
    return view('pages.components-empty-state', ['type_menu' => 'components']);
});
Route::get('/components-gallery', function () {
    return view('pages.components-gallery', ['type_menu' => 'components']);
});
Route::get('/components-hero', function () {
    return view('pages.components-hero', ['type_menu' => 'components']);
});
Route::get('/components-multiple-upload', function () {
    return view('pages.components-multiple-upload', ['type_menu' => 'components']);
});
Route::get('/components-pricing', function () {
    return view('pages.components-pricing', ['type_menu' => 'components']);
});
Route::get('/components-statistic', function () {
    return view('pages.components-statistic', ['type_menu' => 'components']);
});
Route::get('/components-tab', function () {
    return view('pages.components-tab', ['type_menu' => 'components']);
});
Route::get('/components-table', function () {
    return view('pages.components-table', ['type_menu' => 'components']);
});
Route::get('/components-user', function () {
    return view('pages.components-user', ['type_menu' => 'components']);
});
Route::get('/components-wizard', function () {
    return view('pages.components-wizard', ['type_menu' => 'components']);
});

// forms
Route::get('/forms-advanced-form', function () {
    return view('pages.forms-advanced-form', ['type_menu' => 'forms']);
});
Route::get('/forms-editor', function () {
    return view('pages.forms-editor', ['type_menu' => 'forms']);
});
Route::get('/forms-validation', function () {
    return view('pages.forms-validation', ['type_menu' => 'forms']);
});

// google maps
// belum tersedia

// modules
Route::get('/modules-calendar', function () {
    return view('pages.modules-calendar', ['type_menu' => 'modules']);
});
Route::get('/modules-chartjs', function () {
    return view('pages.modules-chartjs', ['type_menu' => 'modules']);
});
Route::get('/modules-datatables', function () {
    return view('pages.modules-datatables', ['type_menu' => 'modules']);
});
Route::get('/modules-flag', function () {
    return view('pages.modules-flag', ['type_menu' => 'modules']);
});
Route::get('/modules-font-awesome', function () {
    return view('pages.modules-font-awesome', ['type_menu' => 'modules']);
});
Route::get('/modules-ion-icons', function () {
    return view('pages.modules-ion-icons', ['type_menu' => 'modules']);
});
Route::get('/modules-owl-carousel', function () {
    return view('pages.modules-owl-carousel', ['type_menu' => 'modules']);
});
Route::get('/modules-sparkline', function () {
    return view('pages.modules-sparkline', ['type_menu' => 'modules']);
});
Route::get('/modules-sweet-alert', function () {
    return view('pages.modules-sweet-alert', ['type_menu' => 'modules']);
});
Route::get('/modules-toastr', function () {
    return view('pages.modules-toastr', ['type_menu' => 'modules']);
});
Route::get('/modules-vector-map', function () {
    return view('pages.modules-vector-map', ['type_menu' => 'modules']);
});
Route::get('/modules-weather-icon', function () {
    return view('pages.modules-weather-icon', ['type_menu' => 'modules']);
});

// auth
Route::get('/auth-forgot-password', function () {
    return view('pages.auth-forgot-password', ['type_menu' => 'auth']);
});
Route::get('/auth-login', function () {
    return view('pages.auth-login', ['type_menu' => 'auth']);
});
Route::get('/auth-login2', function () {
    return view('pages.auth-login2', ['type_menu' => 'auth']);
});
Route::get('/auth-register', function () {
    return view('pages.auth-register', ['type_menu' => 'auth']);
});
Route::get('/auth-reset-password', function () {
    return view('pages.auth-reset-password', ['type_menu' => 'auth']);
});

// error
Route::get('/error-403', function () {
    return view('pages.error-403', ['type_menu' => 'error']);
});
Route::get('/error-404', function () {
    return view('pages.error-404', ['type_menu' => 'error']);
});
Route::get('/error-500', function () {
    return view('pages.error-500', ['type_menu' => 'error']);
});
Route::get('/error-503', function () {
    return view('pages.error-503', ['type_menu' => 'error']);
});

// features
Route::get('/features-activities', function () {
    return view('pages.features-activities', ['type_menu' => 'features']);
});
Route::get('/features-post-create', function () {
    return view('pages.features-post-create', ['type_menu' => 'features']);
});
Route::get('/features-post', function () {
    return view('pages.features-post', ['type_menu' => 'features']);
});
Route::get('/features-profile', function () {
    return view('pages.features-profile', ['type_menu' => 'features']);
});
Route::get('/features-settings', function () {
    return view('pages.features-settings', ['type_menu' => 'features']);
});
Route::get('/features-setting-detail', function () {
    return view('pages.features-setting-detail', ['type_menu' => 'features']);
});
Route::get('/features-tickets', function () {
    return view('pages.features-tickets', ['type_menu' => 'features']);
});

// utilities
Route::get('/utilities-contact', function () {
    return view('pages.utilities-contact', ['type_menu' => 'utilities']);
});
Route::get('/utilities-invoice', function () {
    return view('pages.utilities-invoice', ['type_menu' => 'utilities']);
});
Route::get('/utilities-subscribe', function () {
    return view('pages.utilities-subscribe', ['type_menu' => 'utilities']);
});

// credits
Route::get('/credits', function () {
    return view('pages.credits', ['type_menu' => '']);
});

require __DIR__.'/auth.php';
