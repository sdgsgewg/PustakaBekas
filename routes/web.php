<?php

use App\Models\Book;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController, LoginController, RegisterController, BookController, CategoryController, GenreController, CartController, DashboardBookController, AdminCategoryController, AdminGenreController
};

Route::view('/', 'home', ['title' => 'Home Page', 'books' => Book::all()]);
Route::view('/about', 'about', ['title' => 'About Us']);

Route::resources([
    'books' => BookController::class,
    'genres' => GenreController::class,
    'categories' => CategoryController::class,
    'users' => UserController::class
]);

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/register', [RegisterController::class, 'index']);
    Route::post('/register', [RegisterController::class, 'store']);
});
Route::middleware('auth')->post('/logout', [LoginController::class, 'logout']);

Route::middleware('auth')->group(function () {
    Route::resource('carts', CartController::class);
    Route::post('carts/store/{book:slug}', [CartController::class, 'store'])->name('carts.store');
});

Route::middleware('auth')->prefix('dashboard')->as('auth.')->group(function () {
    Route::get('/', fn() => view('dashboard.index'))->name('dashboard');

    Route::resource('books', DashboardBookController::class);
    Route::get('book/checkSlug', [DashboardBookController::class, 'checkSlug']);
});

Route::middleware([IsAdmin::class])->prefix('dashboard')->as('admin.')->group(function () {
    Route::resource('genres', AdminGenreController::class)->except('show');
    Route::resource('categories', AdminCategoryController::class)->except('show');

    Route::get('genres/checkSlug', [AdminGenreController::class, 'checkSlug']);
    Route::get('categories/checkSlug', [AdminCategoryController::class, 'checkSlug']);
});
