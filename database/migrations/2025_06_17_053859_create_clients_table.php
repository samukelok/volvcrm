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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name');
            $table->string('website')->unique()->nullable(); // e.g. "https://vinesolar.com"
            $table->string('company_email')->unique()->nullable(); // e.g. "admin@vinesolar.com"
            $table->string('subdomain')->unique(); // e.g. "vinesolar"
            $table->string('status')->default('pending'); // pending, active, suspended
            $table->date('onboarded_at')->nullable();
            $table->json('branding')->nullable(); // colors
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
