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
        Schema::create('capsules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message');
            $table->decimal('gps_latitude', 10, 7);
            $table->decimal('gps_longitude', 10, 7);
            $table->string('ip_address', 45);
            $table->foreignId('mood_id')->nullable()->constrained();
            $table->boolean('is_public')->default(true);
            $table->dateTime('reveal_at');
            $table->dateTime('revealed_at')->nullable();
            $table->string('country', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capsules');
    }
};
