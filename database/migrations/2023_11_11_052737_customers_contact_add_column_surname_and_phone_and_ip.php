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
        Schema::table('customer_contacts', function (Blueprint $table) {
            $table->string('surname')->nullable()->after('name');
            $table->ipAddress('ip_address')->after('content');
            $table->string('phone')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_contacts', function (Blueprint $table) {
            //
        });
    }
};
