<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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
    Route::post('cart/add/{course}', [CartController::class, 'addToCart'])->name('user.cart.add');
    Route::delete('cart/remove/{course}', [CartController::class, 'removeFromCart'])->name('user.cart.remove');
    ROute::delete('cart/clear', [CartController::class, 'clearCart'])->name('user.cart.clear');

    //checkout
    Route::get('checkout', [CheckoutController::class, 'checkout'])->name('user.checkout');
    Route::post('checkout/submit', [CheckoutController::class, 'checkoutSubmit'])->name('user.checkout.submit');

    //enroll course
    Route::post('course/enroll/{course}', [CourseController::class, 'enroll'])->name('user.course.enroll');

    //user courses
    Route::get('my-courses', [CourseController::class, 'userCourses'])->name('user.my-courses');
    Route::get('my-courses/{course:slug}/learn/{lecture}', [LectureController::class, 'show'])->name('user.course-video.show');

    //notes
    Route::get('lecture/{lecture}/notes', [NoteController::class, 'getUserLectureNote'])->name('notes.lecture');
    Route::post('notes', [NoteController::class, 'store'])->name('notes.store');

    //history
    Route::get('purchase-history', [OrderController::class, 'history'])->name('user.orders.history');
    Route::get('purchase-history/{order}', [OrderController::class, 'detail'])->name('user.orders.detail');
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
