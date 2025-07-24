<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
/**
 * User routes
 */
Route::get('/', [HomeController::class, 'index'])->name('user.home');
// categories
Route::get('/category/{slugPath}', [HomeController::class, 'showCourseOfCategory'])
    ->where('slugPath', '.*')
    ->name('user.category.show');

Route::get('search', [HomeController::class, 'search'])->name('user.search');

//course detail
Route::get('course/{course:slug}', [CourseController::class, 'show'])->name('user.courses.show');
Route::post('wishlist/add/{course}', [WishlistController::class, 'addToWishlist'])->name('user.wishlist.add');

/**
 * Auth routes
 */

// login
Route::get('login', function () {
    if (Auth::check() && Auth::user()->role_id != 1) {
        return redirect()->route('user.home');
    }
    return view('user.pages.login');
})->name('login');
Route::post('login/submit', [AuthenticatedSessionController::class, 'store'])->name('user.login.submit')->defaults('redirectRoute', 'user.home');

//register
Route::get('register', function () {
    if (Auth::check() && Auth::user()->role_id != 1) {
        return redirect()->route('user.home');
    }
    return view('user.pages.register');
})->name('user.register');
Route::post('register/submit', [RegisteredUserController::class, 'store'])->name('user.register.submit')->defaults('redirectRoute', 'user.home');

//static pages
Route::get('/pages/{page:slug}', [PageController::class, 'show'])->name('pages.show');

//reviews
Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');


Route::middleware('auth')->group(function () {
    //logout
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('user.logout')->defaults('redirectRoute', 'user.home');

    //profile
    Route::get('profile/{user}', [UserController::class, 'edit'])->name('user.profile')->defaults('isAdmin', false);
    Route::patch('profile/{user}/update', [UserController::class, 'update'])->name('user.profile.update')->defaults('isAdmin', false);

    //wishlist
    Route::get('wishlist', [WishlistController::class, 'wishlist'])->name('user.wishlist');

    Route::delete('wishlist/remove/{course}', [WishlistController::class, 'removeFromWishlist'])->name('user.wishlist.remove');

    //cart
    Route::get('cart', [CartController::class, 'index'])->name('user.cart');
    Route::get('/cart/total', [CartController::class, 'getCartTotal'])->name('user.cart.get-total');
    Route::post('cart/buy-now/{course}', [CartController::class, 'buyNow'])->name('user.cart.buy-now');
    Route::post('cart/add/{course}', [CartController::class, 'addToCart'])->name('user.cart.add')->withoutMiddleware('auth');
    Route::delete('cart/remove/{course}', [CartController::class, 'removeFromCart'])->name('user.cart.remove');
    ROute::delete('cart/clear', [CartController::class, 'clearCart'])->name('user.cart.clear');

    //checkout
    Route::get('checkout', [CheckoutController::class, 'checkout'])->name('user.checkout');
    Route::post('checkout/submit', [CheckoutController::class, 'checkoutSubmit'])->name('user.checkout.submit');
    Route::post('checkout/momo', [CheckoutController::class, 'momoPayment'])->name('user.checkout.momo');
    Route::get('checkout/momo/return', [CheckoutController::class, 'momoReturn'])->name('user.checkout.momo.return');

    //enroll course
    Route::post('course/enroll/{course}', [CourseController::class, 'enroll'])->name('user.course.enroll');

    //user courses
    Route::get('my-courses', [CourseController::class, 'userCourses'])->name('user.my-courses');
    Route::get('my-courses/{course:slug}/learn/{lecture}', [LectureController::class, 'show'])->name('user.course-video.show');

    //notes
    Route::get('notes', [NoteController::class, 'getUserLectureNote'])->name('notes.index');
    Route::post('notes', [NoteController::class, 'store'])->name('notes.store');
    Route::put('notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');

    //history
    Route::get('purchase-history', [OrderController::class, 'history'])->name('user.orders.history');
    Route::get('purchase-history/{order}', [OrderController::class, 'detail'])->name('user.orders.detail');

    //reviews
    Route::post('reviews', [ReviewController::class, 'store'])->name('reviews.store');
});


/**
 * Admin routes
 */
Route::middleware([IsAdmin::class])->prefix('admin')->group(function () {
    /**
     * Auth Routes
     */
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('admin.logout')->defaults('redirectRoute', 'admin.login');

    /**
     * Module Routes
     */
    Route::get('/', [DasboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', UserController::class);
    Route::resource('ccategories', CourseCategoryController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('lectures', LectureController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('pages', PageController::class)->except(['show']);
    Route::get('reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');

    Route::prefix('settings')->group(function () {
        Route::get('meta-data', [SettingController::class, 'edit'])->name('settings.meta.edit');
        Route::post('meta-data', [SettingController::class, 'update'])->name('settings.meta.update');
        Route::get('email', [SettingController::class, 'emailSettingEdit'])->name('settings.email.edit');
        Route::post('email', [SettingController::class, 'emailSettingUpdate'])->name('settings.email.update');
        Route::get('contact', [SettingController::class, 'contactSettingEdit'])->name('settings.contact.edit');
        Route::post('contact', [SettingController::class, 'contactSettingUpdate'])->name('settings.contact.update');
        Route::get('social', [SettingController::class, 'socialSettingEdit'])->name('settings.social.edit');
        Route::post('social', [SettingController::class, 'socialSettingUpdate'])->name('settings.social.update');
        Route::resource('sliders', SliderController::class);
    });

    Route::get('permissions', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
});

Route::prefix('admin')->group(function () {
    Route::get('login', function () {
        if (Auth::check() && Auth::user()->role_id == 1) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.pages.login');
    })->name('admin.login');
    Route::post('login/submit', [AuthenticatedSessionController::class, 'store'])
        ->name('admin.login.submit')
        ->defaults('redirectRoute', 'admin.dashboard');
});


// Auth::routes();
