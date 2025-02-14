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
        Schema::table('details', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('company')->nullable();
            $table->string('date_time')->nullable();
            $table->string('email')->nullable();
            $table->string('Phone_no')->nullable();
            $table->string('company_size')->nullable();
            $table->string('form_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('details', function (Blueprint $table) {
            //
        });
    }
};
