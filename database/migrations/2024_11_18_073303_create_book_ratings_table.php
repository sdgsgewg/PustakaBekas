<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_reviews', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('transaction_book_id')->constrained('transaction_books')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade'); // Direct reference to the book
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('rating'); // e.g., 1 to 5
            $table->text('feedback')->nullable(); // Optional comments
            $table->boolean('isRated')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_ratings');
    }
};
