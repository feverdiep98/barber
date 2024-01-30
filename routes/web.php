<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BookingListController;
use App\Http\Controllers\Admin\BookingServiceController;
use App\Http\Controllers\Admin\BrandProductController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManageOrderController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\profileController as AdminProfileController;
use App\Http\Controllers\Admin\ShipController;
use App\Http\Controllers\Admin\ShoppingController;
use App\Http\Controllers\Admin\SlotController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\BookingController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\GoogleController;
use App\Http\Controllers\Client\ShopListController;
use App\Http\Controllers\Client\UserController;
use App\Http\Controllers\Client\ViewOrderController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController as ControllersUserController;
use App\Http\Middleware\CheckOrderAccess;
use App\Mail\DemoEmail;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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

Route::get('403', function () {
    return view('admin.403');
})->name('403');
Route::get('header', function () {
    return view('client.pages.header.header');
});
Route::get('home', function () {
    return view('client.pages.home.home');
});
Route::get('service', function () {
    return view('client.pages.Service-pages.Service');
})->name('service');
Route::get('about', function () {
    return view('client.pages.about.about_us');
})->name('about');
Route::get('contact', function () {
    return view('client.pages.contact.contact-us');
})->name('contact');
Route::get('shop-detail', function () {
    return view('client.pages.shop.shop-detail');
});

Route::get('dangky', [UserController::class, 'index'])->name('dangky');
Route::post('client/registers/saveUser', [UserController::class, 'saveUser'])->name('client.registers.saveUser');
Route::post('client/registers/signIn', [UserController::class, 'signIn'])->name('client.registers.signIn');
Route::get('logout', [UserController::class, 'logout'])->name('logout');
Route::get('/', function () {
    return view('client.pages.home.home');
});

Route::get('booking', [BookingController::class, 'index'])->name('index');
Route::post('booking', [BookingController::class, 'add_booking'])->name('add_booking');
Route::get('/get-available-slots',[BookingController::class ,'get_available_slot'])->name('available-slots');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Chart


Route::get('/account', [AdminController::class, 'logon'])->name('logon');
Route::post('/account',[AdminController::class,'access'])->name('admin.login');
Route::get('/sign-out',[AdminController::class,'signout'])->name('admin.signout');
Route::middleware('auth.admin')->name('admin.')->group(function () {
    Route::get('admin', function() {
        return view('admin.layout.master');
    })->name('admin');

    Route::get('admin/chart', [DashboardController::class, 'combinedChart'])
    ->name('chart');

    //profile
    Route::get('admin/users/profile',[AdminProfileController::class, 'index'])->name('users.profile');
    Route::post('admin/users/update/{id}',[AdminProfileController::class, 'update'])->name('users.update');

    //admin
    Route::post('/activate-user/{userId}', [AdminController::class, 'activateUser']);
    Route::get('admin/user/index',[AdminController::class, 'index'])->name('user.index');
    Route::get('admin/user/create',[AdminController::class, 'create'])->name('user.create');
    Route::post('admin/user/store',[AdminController::class, 'store'])->name('user.store');
    Route::post('admin/user/update/{id}',[AdminController::class, 'update'])->name('user.update');
    Route::get('admin/user/detail/{id}',[AdminController::class, 'detail'])->name('user.detail');
    Route::delete('admin/user/delete/{id}',[AdminController::class, 'destroy'])->name('user.destroy');
    Route::delete('admin/user/deleteAll', [AdminController::class, 'deleteAll'])->name('user.deleteAll');

    //product
    Route::get('admin/shopping_details/create', [ShoppingController::class, 'create'])->name('shopping_details.create');
    Route::post('admin/shopping_details/store', [ShoppingController::class, 'store'])->name('shopping_details.store');
    Route::get('admin/shopping_details/show/{id}', [ShoppingController::class, 'show'])->name('shopping_details.show');
    Route::post('admin/shopping_details/update/{id}', [ShoppingController::class, 'update'])->name('shopping_details.update');
    Route::delete('admin/shopping_details/delete/{id}', [ShoppingController::class, 'destroy'])->name('shopping_details.destroy');
    Route::post('admin/shopping_details/restore/{product}', [ShoppingController::class, 'restore'])->name('shopping_details.restore');
    Route::post('admin/shopping_details/slug', [ShoppingController::class, 'getslug'])->name('shopping_details.slug');
    Route::get('admin/shopping_details/list', [ShoppingController::class, 'index'])->name('shopping_details.list');
    Route::delete('admin/shopping_details/deleteAll', [ShoppingController::class, 'deleteAll'])->name('shopping_details.deleteAll');
    Route::get('admin/shopping_details/index', [ShoppingController::class, 'index'])->name('shopping_details.index');
    // Service
    Route::get('admin/booking_service/index', [BookingServiceController::class, 'index'])->name('booking_service.index');
    Route::get('admin/booking_service/create', [BookingServiceController::class, 'create'])->name('booking_service.create');
    Route::post('admin/booking_service/store', [BookingServiceController::class, 'store'])->name('booking_service.store');
    Route::delete('admin/booking_service/delete/{id}', [BookingServiceController::class, 'delete'])->name('booking_service.delete');
    Route::get('admin/booking_service/detail/{id}', [BookingServiceController::class, 'detail'])->name('booking_service.detail');
    Route::delete('admin/booking_service/deleteAll', [BookingServiceController::class, 'deleteAll'])->name('booking_service.deleteAll');
    Route::post('admin/booking_service/update/{id}', [BookingServiceController::class, 'update'])->name('booking_service.update');

    //brand
    Route::get('admin/brand/list', [BrandProductController::class, 'index'])->name('brand.list');
    Route::get('admin/brand/create', [BrandProductController::class, 'create'])->name('brand.create');
    Route::post('admin/brand/save', [BrandProductController::class, 'store'])->name('brand.save');
    Route::post('admin/brand/slug', [BrandProductController::class, 'getslug'])->name('brand.slug');
    Route::delete('admin/brand/deleteAll', [BrandProductController::class, 'deleteAll'])->name('brand.deleteAll');
    Route::get('admin/brand/detail/{id}', [BrandProductController::class, 'detail'])->name('brand.detail');
    Route::post('admin/brand/update/{id}', [BrandProductController::class, 'update'])->name('brand.update');
    Route::delete('admin/brand/delete/{id}', [BrandProductController::class, 'destroy'])->name('brand.delete');
    //Booking List
    Route::get('admin/booking_list/list', [BookingListController::class, 'index'])->name('booking_list.list');
    Route::post('admin/booking_list/store', [BookingListController::class, 'store'])->name('booking_list.store');
    Route::delete('admin/booking_list/delete/{id}', [BookingListController::class, 'delete'])->name('booking_list.delete');
    Route::delete('admin/booking_list/deleteAll', [BookingListController::class, 'deleteAll'])->name('booking_list.deleteAll');
    Route::get('admin/booking_list/detail/{id}', [BookingListController::class, 'detail'])->name('booking_list.detail');
    Route::post('admin/booking_list/update/{id}', [BookingListController::class, 'update'])->name('booking_list.update');

    Route::get('shopping_details-upload-image', [ShoppingController::class, 'uploadImage'])->name('shopping_details.image.upload');
    Route::get('admin/shopping_category/list', [ProductCategoryController::class, 'index'])->name('shopping_category.list');
    Route::get('admin/shopping_category/create', function () {
        return view('admin.shopping_category.create');
    })->name('shopping_category.create');
    Route::post('admin/shopping_category/save', [ProductCategoryController::class, 'store'])->name('shopping_category.save');
    Route::post('admin/shopping_category/slug', [ProductCategoryController::class, 'getslug'])->name('shopping_category.slug');
    Route::delete('admin/shopping_category/deleteAll', [ProductCategoryController::class, 'deleteAll'])->name('shopping_category.deleteAll');
    Route::get('admin/shopping_category/{id}', [ProductCategoryController::class, 'detail'])->name('shopping_category.detail');
    Route::post('admin/shopping_category/update/{id}', [ProductCategoryController::class, 'update'])->name('shopping_category.update');
    Route::delete('admin/shopping_category/delete/{id}', [ProductCategoryController::class, 'destroy'])->name('shopping_category.delete');

    //Manager Order
    Route::delete('admin/manage_order/deleteAll', [ManageOrderController::class, 'deleteAll'])->name('manage_order.deleteAll');
    Route::get('admin/manage_order/detail/{id}', [ManageOrderController::class, 'detail'])->name('manage_order.detail');
    Route::delete('admin/manage_order/delete/{id}', [ManageOrderController::class, 'destroy'])->name('manage_order.delete');
    Route::get('admin/manage_order/index', [ManageOrderController::class, 'index'])->name('manage_order.index');
    Route::post('admin/manage_order/update/{id}', [ManageOrderController::class, 'update'])->name('manage_order.update');
    Route::post('admin/manage_order/{order_id}/add_product', [ManageOrderController::class, 'add_product'])->name('manage_order.add_product');
    Route::post('/admin/manage_order/confirm/{id}', [ManageOrderController::class,'confirm_order'])->name('manage_order.confirm');
    Route::post('/admin/manage_order/complete/{id}', [ManageOrderController::class,'complete'])->name('manage_order.complete');

    //ship
    Route::get('admin/shipping/index', [ShipController::class, 'index'])->name('shipping.index');
    Route::post('select-delivery', [ShipController::class,'select_delivery'])->name('select-delivery');
    Route::post('insert-delivery', [ShipController::class,'insert_delivery'])->name('insert-delivery');
    Route::post('update-delivery/{fee_id}', [ShipController::class,'update_delivery'])->name('update_delivery');

    //slot
    Route::get('admin/slot/list', [SlotController::class, 'index'])->name('slot.list');
    Route::get('admin/slot/create', [SlotController::class, 'create'])->name('slot.create');
    Route::post('admin/slot/save', [SlotController::class, 'store'])->name('slot.save');
    Route::delete('admin/slot/deleteAll', [SlotController::class, 'deleteAll'])->name('slot.deleteAll');
    Route::get('admin/slot/detail/{id}', [SlotController::class, 'detail'])->name('slot.detail');
    Route::post('admin/slot/update/{id}', [SlotController::class, 'update'])->name('slot.update');
    Route::delete('admin/slot/delete/{id}', [SlotController::class, 'destroy'])->name('slot.delete');
    Route::post('admin/slot/confirm/{id}', [SlotController::class, 'confirm'])->name('slot.confirm');

    //calendar
    Route::get('/calendar-events', [CalendarController::class, 'getCalendar']);
    Route::delete('/delete-events/{id}', [CalendarController::class, 'delete']);
    Route::post('/edit-events/{id}', [CalendarController::class, 'edit']);
    Route::get('/show-events/{id}', [CalendarController::class, 'show']);
    Route::post('/create-events', [CalendarController::class, 'store']);
    Route::get('/get-services', [CalendarController::class, 'getService']);

});
//route admin shopping_details
// Route::get('admin/shopping_details/create',[ShoppingController::class,'create'])->name('admin.shopping_details.create');
// Route::post('admin/shopping_details/store',[ShoppingController::class,'store'])->name('admin.shopping_details.store');
// Route::get('admin/shopping_details/show/{id}',[ShoppingController::class,'show'])->name('admin.shopping_details.show');
// Route::post('admin/shopping_details/update/{id}',[ShoppingController::class,'update'])->name('admin.shopping_details.update');
// Route::post('admin/shopping_details/edit/{id}',[ShoppingController::class,'edit'])->name('admin.shopping_details.edit');
// Route::get('admin/shopping_details/delete/{id}',[ShoppingController::class,'destroy'])->name('admin.shopping_details.destroy');
// Route::post('admin/shopping_details/restore/{product}', [ShoppingController::class, 'restore'])->name('admin.shopping_details.restore');
// Route::post('admin/shopping_details/slug', [ShoppingController::class, 'getslug'])->name('admin.shopping_details.slug');
// Route::get('admin/shopping_details/list', [ShoppingController::class, 'index'])
// ->name('admin.shopping_details.list');
// Route::get('admin/shopping_details/deleteAll', [ShoppingController::class, 'deleteAll'])
// ->name('admin.shopping_details.deleteAll');
// Route::get('admin/shopping_details/index',[ShoppingController::class, 'index'])->name('admin.shopping_details.index');
// // Service
// Route::get('admin/booking_service/index', [BookingServiceController::class, 'index'])->name('admin.booking_service.index');
// Route::get('admin/booking_service/create', [BookingServiceController::class, 'create'])->name('admin.booking_service.create');
// Route::post('admin/booking_service/store', [BookingServiceController::class, 'store'])->name('admin.booking_service.store');
// Route::get('admin/booking_service/delete/{id}', [BookingServiceController::class, 'delete'])->name('admin.booking_service.delete');
// Route::get('admin/booking_service/detail/{id}', [BookingServiceController::class, 'detail'])->name('admin.booking_service.detail');
// Route::get('admin/booking_service/deleteAll', [BookingServiceController::class, 'deleteAll'])->name('admin.booking_service.deleteAll');
// Route::post('admin/booking_service/update/{id}', [BookingServiceController::class, 'update'])->name('admin.booking_service.update');
// //Booking List
// Route::get('admin/booking_list/index', [BookingListController::class, 'index'])->name('admin.booking_list.index');
// Route::post('admin/booking_list/store', [BookingListController::class, 'store'])->name('admin.booking_list.store');
// Route::get('admin/booking_list/delete/{id}', [BookingListController::class, 'delete'])->name('admin.booking_list.delete');
// Route::get('admin/booking_list/deleteAll', [BookingListController::class, 'deleteAll'])->name('admin.booking_list.deleteAll');
// Route::get('admin/booking_list/detail/{id}', [BookingListController::class, 'detail'])->name('admin.booking_list.detail');
// Route::post('admin/booking_list/update/{id}', [BookingListController::class, 'update'])->name('admin.booking_list.update');

// Route::get('shopping_details-upload-image',[ShoppingController::class, 'uploadImage'])
// ->name('admin.shopping_details.image.upload');
// // Route::get('admin/shopping_details/create',function(){
// //     return view('admin.shopping_details.create');
// // })->name('admin.shopping_details.create');
// require __DIR__.'/auth.php';

// //route admin Shopping_category

// Route::get('admin/shopping_category/list', [ProductCategoryController::class, 'index'])
// ->name('admin.shopping_category.list');

// Route::get('admin/shopping_category/create',function(){
//     return view('admin.shopping_category.create');
// })->name('admin.shopping_category.create');

// Route::post('admin/shopping_category/save', [ProductCategoryController::class, 'store'])
// ->name('admin.shopping_category.save');

// Route::post('admin/shopping_category/slug', [ProductCategoryController::class, 'getslug'])
// ->name('admin.shopping_category.slug');
// Route::get('admin/shopping_category/deleteAll', [ProductCategoryController::class, 'deleteAll'])
// ->name('admin.shopping_category.deleteAll');
// Route::get('admin/shopping_category/{id}',[ProductCategoryController::class, 'detail'])
// ->name('admin.shopping_category.detail');

// Route::post('admin/shopping_category/update/{id}',[ProductCategoryController::class, 'update'])
// ->name('admin.shopping_category.update');
// Route::post('admin/shopping_category/delete/{id}',[ProductCategoryController::class, 'destroy'])
// ->name('admin.shopping_category.delete');
Auth::routes();

Route::get('home', [HomeController::class, 'index'])->name('home.shopping_details');
Route::get('home', [HomeController::class, 'index'])->name('home');
// Route::get('shop-list', [ShopListController::class, 'index'])->name('shop-list.shopping_details');
// Route::get('shop-list-detail', [ShopListController::class, 'detail'])->name('shop-list.shopping_detail.slug');

// Route::middleware(['auth'])->group(function () {
//     Route::get('view-order', [ViewOrderController::class, 'index'])->name('view-order');
// });

Route::get('shopping-cart', [CartController::class, 'index'])->name('shopping_details.shopping-cart');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
require __DIR__ . '/cart/web.php';
require __DIR__ . '/product/web.php';
Route::get('/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
Route::get('/send-mail', [EmailController::class, 'sendEmail'])->name('send-mail');
