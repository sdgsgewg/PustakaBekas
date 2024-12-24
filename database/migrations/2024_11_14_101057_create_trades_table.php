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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_1_id')->constrained('users')->onDelete('cascade'); // User initiating the trade
            $table->foreignId('user_2_id')->constrained('users')->onDelete('cascade'); // User receiving the trade offer
            $table->foreignId('book_2_id')->constrained('books')->onDelete('cascade'); // Book offered by user_2
            $table->enum('trade_status', ['Pending', 'Accepted', 'Declined', 'In Progress', 'Completed', 'Cancelled'])->default('Pending');
            $table->boolean('isPaid')->default(false);
            $table->boolean('isReceived')->default(false);

            $table->index(['trade_status', 'user_1_id']);
            $table->index(['trade_status', 'user_2_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
