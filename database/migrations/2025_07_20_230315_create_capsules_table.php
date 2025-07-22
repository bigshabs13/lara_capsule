<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapsulesTable extends Migration
{
    public function up()
    {
        Schema::create('capsules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message');
            $table->string('mood')->nullable(); 
            $table->decimal('gps_lat', 10, 7)->nullable();
            $table->decimal('gps_long', 10, 7)->nullable();
            $table->string('ip_address')->nullable();
            $table->boolean('is_public')->default(false);
            $table->string('country')->nullable();
            $table->dateTime('reveal_at');
            $table->dateTime('revealed_at')->nullable();
            $table->foreignId('mood_id')->nullable()->constrained('moods')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('capsules');
    }
}