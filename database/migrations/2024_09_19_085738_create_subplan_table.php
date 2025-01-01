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
        Schema::create('subplans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subgroup_id');
            $table->string('name');
            $table->string('price')->nullable();
            $table->enum('option', ['monthly', 'yearly'])->default('monthly');
            $table->string('user_limit')->nullable();
            $table->string('site_limit')->nullable();
            $table->string('company_limit')->nullable();
            $table->string('features')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subplans');
    }
};
