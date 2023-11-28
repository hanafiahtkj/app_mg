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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('investment_duration_id');
            $table->decimal('amount', 12, 2);
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();
            $table->timestamps();

            $table->foreign('investment_duration_id')->references('id')->on('investment_durations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
