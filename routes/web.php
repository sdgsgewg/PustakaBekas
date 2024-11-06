<?php

use App\Models\Book;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController, LoginController, RegisterController, BookController, CategoryController, GenreController, CartController, DashboardBookController, AdminCategoryController, AdminGenreController,
    HomeController,
    TransactionController
};

Route::get('/', [HomeController::class, 'index']);
Route::view('/about', 'about', ['title' => 'About Us']);

Route::resources([
    'books' => BookController::class,
    'genres' => GenreController::class,
    'categories' => CategoryController::class,
    'users' => UserController::class
]);

Route::get('book/genres/{categorySlug}', [BookController::class, 'getGenresByCategory'])->name('bookFilter.getGenresByCategory');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/register', [RegisterController::class, 'index']);
    Route::post('/register', [RegisterController::class, 'store']);
});
Route::middleware('auth')->post('/logout', [LoginController::class, 'logout']);

Route::middleware('auth')->prefix('carts')->as('carts.')->group(function () {
    Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::resource('/', CartController::class)->parameters(['' => 'cart'])->except(['create', 'edit']);
    Route::post('store/{book:slug}', [CartController::class, 'store'])->name('store');
    Route::post('update-is-checked', [CartController::class, 'updateIsChecked'])->name('updateIsChecked');
    Route::post('update-quantity', [CartController::class, 'updateQuantity'])->name('updateQuantity');
});

Route::middleware('auth')->prefix('transactions')->as('transactions.')->group(function () {
    Route::get('/orderRequest', [TransactionController::class, 'orderRequest'])->name('orderRequest');
    Route::post('updateStatus/{transaction}', [TransactionController::class, 'updateStatus'])->name('updateStatus');
    Route::resource('/', TransactionController::class)->parameters(['' => 'transaction']);
});

Route::middleware('auth')->prefix('dashboard')->as('auth.')->group(function () {
    Route::get('/', fn() => view('dashboard.index'))->name('dashboard');

    Route::resource('books', DashboardBookController::class);
    Route::get('book/checkSlug', [DashboardBookController::class, 'checkSlug']);
    Route::get('book/genres/{categoryId}', [DashboardBookController::class, 'getGenresByCategory'])->name('books.getGenresByCategory');
});

Route::middleware([IsAdmin::class])->prefix('dashboard')->as('admin.')->group(function () {
    Route::resource('genres', AdminGenreController::class)->except('show');
    Route::resource('categories', AdminCategoryController::class)->except('show');

    Route::get('genres/checkSlug', [AdminGenreController::class, 'checkSlug']);
    Route::get('categories/checkSlug', [AdminCategoryController::class, 'checkSlug']);
});
