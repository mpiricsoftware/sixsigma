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
        Schema::table('inquiry', function (Blueprint $table) {
          $table->enum('type', ['Online', 'In-Person'])->nullable()->default(null);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inquiry', function (Blueprint $table) {
          $table->enum('type', ['Online', 'In-Person'])->nullable()->default(null);
        });
    }
};