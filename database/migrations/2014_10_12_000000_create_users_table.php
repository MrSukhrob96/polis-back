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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            $table->string('firstName');
            $table->string('lastName');
            $table->string('surName')->nullable();

            $table->string('email')->unique();
            $table->string('password');

            $table->dateTime("passwordExpiryDate");
            $table->boolean("hasToChangePasswordAfterLogin")->default(0);
            $table->dateTime("lastActivityUser")->nullable();
            $table->string("status")->nullable();
            $table->rememberToken();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
