<?php

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController, LoginController, RegisterController, BookController, CategoryController, GenreController, CartController, DashboardBookController, AdminCategoryController, AdminGenreController,
    CommentController,
    HomeController,
    ReplyController,
    TradeController,
    TransactionController
};

Route::get('/', [HomeController::class, 'index']);
Route::view('/about', 'about', ['title' => 'About Us']);

Route::resources([
    'books' => BookController::class,
    'genres' => GenreController::class,
    'categories' => CategoryController::class
]);

Route::middleware('auth')->get('/books/{book:slug}', [BookController::class, 'show'])->name('books.show');
Route::get('/filtered-books', [BookController::class, 'filter'])->name('books.filter');

Route::prefix('books')->as('books.')->group(function() {
    Route::get('/category/{category:slug}', [BookController::class, 'showBookCategory'])->name('category');
    Route::get('/genre/{genre:slug}', [BookController::class, 'showBookGenre'])->name('genre');
    Route::get('/seller/{seller:username}', [BookController::class, 'showSeller'])->name('seller');
});

Route::get('book/genres/{categorySlug:slug}', [BookController::class, 'getGenresByCategory'])->name('bookFilter.getGenresByCategory');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});
Route::middleware('auth')->post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('users')->as('users.')->group(function() {
    Route::resource('/', UserController::class)->parameters(['' => 'user']);
});

Route::resource('/comments', CommentController::class)->middleware('auth');
Route::resource('/replies', ReplyController::class)->middleware('auth');
Route::post('/sendFeedback', [BookController::class, 'sendFeedback'])->name('sendFeedback');

Route::middleware('auth')->prefix('carts')->as('carts.')->group(function () {
    // Buat checkout buku
    Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');

    // buat manage data-data cart
    Route::resource('/', CartController::class)->parameters(['' => 'cart'])->except(['create', 'edit']);
    Route::post('update-is-checked', [CartController::class, 'updateIsChecked'])->name('updateIsChecked');
    Route::post('update-quantity', [CartController::class, 'updateQuantity'])->name('updateQuantity');
});

Route::middleware('auth')->prefix('transactions')->as('transactions.')->group(function () {
    Route::get('/orderRequest', [TransactionController::class, 'orderRequest'])->name('orderRequest');
    Route::post('updateStatus/{transaction}', [TransactionController::class, 'updateStatus'])->name('updateStatus');
    Route::resource('/', TransactionController::class)->parameters(['' => 'transaction']);
});

Route::middleware('auth')->prefix('trades')->as('trades.')->group(function () {
    Route::get('/tradeRequest', [TradeController::class, 'tradeRequest'])->name('tradeRequest');

    Route::post('updateStatus/{trade}', [TradeController::class, 'updateStatus'])->name('updateStatus');

    Route::resource('/', TradeController::class)->parameters(['' => 'trade']);
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
