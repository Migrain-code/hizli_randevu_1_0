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
            $table->boolean('is_featured')->default(0)->after('order_number')->comment('1=> öne çıkan');
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
