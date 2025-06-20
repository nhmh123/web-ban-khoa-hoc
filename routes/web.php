<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\Admin\DasboardController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\WishlistController;

/**
 * User routes
 */
Route::get('/', [HomeController::class, 'index'])->name('user.home');

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

    //course detail
    Route::get('course/{course:slug}',[CourseController::class,'show'])->name('user.courses.show');

    //wishlist
    Route::get('wishlist', [WishlistController::class, 'wishlist'])->name('user.wishlist');
    Route::post('wishlist/add/{course}', [WishlistController::class, 'addToWishlist'])->name('user.wishlist.add');
    Route::delete('wishlist/remove/{course}', [WishlistController::class, 'removeFromWishlist'])->name('user.wishlist.remove');
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
