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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('usertype');
            $table->unsignedBigInteger('site_id')->nullable()->after('company_id');
            $table->unsignedBigInteger('department_id')->nullable()->after('site_id');
            $table->enum('status',['0','1'])->default('1')->comment('0 - Inactive | 1 - Active')->after('profile_photo_path');
            $table->unsignedBigInteger('subgroup_id')->nullable()->after('password');
            $table->unsignedBigInteger('subplan_id')->nullable()->after('subgroup_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('company_id');
            $table->dropColumn('site_id');
            $table->dropColumn('department_id');
            $table->dropColumn('status');
            $table->dropColumn('subgroup_id');
            $table->dropColumn('subplan_id');
        });
    }
};
