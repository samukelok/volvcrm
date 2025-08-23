<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('funnel_step_email_template', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funnel_step_id')->constrained()->onDelete('cascade');
            $table->foreignId('email_template_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('order_in_step')->default(1); // multiple emails inside 1 step
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funnel_step_email_template');
    }
};
