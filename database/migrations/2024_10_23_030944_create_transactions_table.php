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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique()->nullable();
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->integer('total_price');
            $table->integer('shipping_fee');
            $table->integer('service_fee');
            $table->integer('grand_total_price');
            $table->enum('payment_method', ['Gopay', 'OVO', 'ShopeePay']);
            $table->enum('transaction_status', ['Not Paid', 'Pending', 'Accepted', 'Delivered', 'Returned', 'Completed', 'Cancelled'])->default('Pending');
            $table->boolean('isReceived')->default(false);

            $table->timestamp('payment_time')->nullable();
            $table->timestamp('shipping_time')->nullable();
            $table->timestamp('completion_time')->nullable(); 

            $table->index(['transaction_status', 'buyer_id']);
            $table->index(['transaction_status', 'seller_id']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
