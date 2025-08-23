<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('funnel_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funnel_id')->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->unsignedInteger('step_order')->default(1);
            $table->unsignedInteger('delay_hours')->default(0); // Delay before running step
            $table->string('condition')->nullable(); // e.g. "opened_last_email", "clicked_cta"
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funnel_steps');
    }
};
