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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Userテーブルへの参照
            $table->string('last_name');
            $table->string('first_name');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->string('image1')->nullable(); // 画像1
            $table->string('image2')->nullable(); // 画像2
            $table->string('image3')->nullable(); // 画像3
            $table->string('nickname')->nullable(); // ニックネーム
            $table->timestamps();

            // user_idをusersテーブルのidに外部キーとして設定
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
