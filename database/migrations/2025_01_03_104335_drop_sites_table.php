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
        Schema::dropIfExists('sites');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('subgroups');
        Schema::dropIfExists('subplans');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('video_streams');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('site_id');
            $table->dropColumn('department_id');
            $table->dropColumn('subplan_id');
            $table->dropColumn('subgroup_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
