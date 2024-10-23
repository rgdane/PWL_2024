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
        Schema::create('m_profile', function (Blueprint $table) {
            $table->id('profile_id');
            $table->unsignedBigInteger('user_id')->index();
            $table->string('profile_email', 255);
            $table->string('profile_telepon', 255);
            $table->string('profile_alamat', 255);
            $table->string('profile_foto_url', 255);
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_profile');
    }
};
