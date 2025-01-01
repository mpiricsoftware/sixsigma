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
        Schema::create('video_streams', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('protocol')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('camera_ip')->nullable();
            $table->string('port')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_streams');
    }
};
