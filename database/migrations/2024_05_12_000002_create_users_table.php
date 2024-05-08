<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id', true);
            $table->integer('users_type')->index()->unsigned();
            $table->foreign('users_type')->references('id')->on('users_type')->onDelete('cascade');
            $table->string('name', 50)->nullable();
            $table->string('avatar', 100)->default('static/icon/user.png');
            $table->string('phone', 50)->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->default(Carbon::now());
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
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
