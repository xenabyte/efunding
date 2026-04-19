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
        Schema::create('levies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Security Levy 2024" 
            $table->decimal('amount', 15, 2);
            $table->enum('applies_to', ['all', 'resident', 'diaspora'])->default('all');
            $table->date('due_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('levies');
    }
};
