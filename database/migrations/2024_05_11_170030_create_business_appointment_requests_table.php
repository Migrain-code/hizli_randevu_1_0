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
        Schema::create('business_appointment_requests', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->string('goal_time_type');
            $table->string('goal_time');
            $table->longText('note');
            $table->string('user_name');
            $table->string('phone');
            $table->string('email');
            $table->tinyInteger('contact_type')->default(1)->comment('1 => call');
            $table->json('questions')->nullable();
            $table->json('added_services')->nullable();
            $table->dateTime('call_date')->nullable();
            $table->boolean('phone_verification')->default(0)->comment('1 => doğrulandı');
            $table->boolean('status')->default(0)->comment('0=> bekliyor; 1 => arandı, 2 => aranmadı, 3 => ileri tarhli');
            $table->ipAddress();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_appointment_requests');
    }
};
