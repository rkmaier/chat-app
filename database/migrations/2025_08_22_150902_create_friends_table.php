<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up(): void
    {
        Schema::create('friends', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('friend_id');
            $table->enum('status', ['pending', 'accepted', 'blocked'])->default('pending');
            $table->unsignedBigInteger('requested_by');
            $table->timestamps();


            $table->unique(['user_id', 'friend_id']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('friend_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('requested_by')->references('id')->on('users')->cascadeOnDelete();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('friends');
    }
};
