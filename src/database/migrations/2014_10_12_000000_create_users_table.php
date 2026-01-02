<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); //PK
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->dateTime('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('profile_image_path', 255)->nullable();
            $table->string('postal_code', 8)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('building', 255)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
