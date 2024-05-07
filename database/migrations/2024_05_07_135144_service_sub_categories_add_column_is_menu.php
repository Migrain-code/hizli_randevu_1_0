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
        Schema::table('service_sub_categories', function (Blueprint $table) {
            $table->boolean('status')->default(0)->after('is_featured');
            $table->boolean('is_menu')->default(0)->after('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_sub_categories', function (Blueprint $table) {
            //
        });
    }
};
