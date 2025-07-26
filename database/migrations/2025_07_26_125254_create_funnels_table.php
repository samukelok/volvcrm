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
        Schema::create('funnels', function (Blueprint $table) {
            $table->id();
            $table->string('title'); //e.g., Solar Panel Lead Generation, Summer Sale Campaign
            $table->text('goal'); //Describe what you want to achieve with this funnel. 
            $table->text('target_audience');
            $table->string('cta');
            $table->text('notes')->nullable(); //Addtional Requests
            $table->date('deadline');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->string('status')->default('submitted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funnels');
    }
};
