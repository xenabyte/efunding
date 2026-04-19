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
        Schema::create('contributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('levy_id')->nullable()->constrained(); // For Fixed Levies
            $table->foreignId('campaign_id')->nullable()->constrained(); // For Crowdfunding 
            $table->decimal('amount', 15, 2);
            $table->string('payment_gateway'); // paystack, monnify, upperlink, expresspay
            $table->string('transaction_reference')->unique();
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending'); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contributions');
    }
};
