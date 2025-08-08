<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        Schema::create('funnels', function (Blueprint $table) {
            $table->id();
            $table->string('title'); 
            $table->text('goal'); 
            $table->text('target_audience');
            $table->string('cta');
            $table->text('notes')->nullable(); 
            $table->date('deadline');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->enum('priority', ['Low', 'Normal', 'High', 'Urgent'])->default('Normal');
            $table->enum('status', ['Pending', 'In Progress', 'Live', 'Complete'])->default('Pending');
            $table->string('preview_link')->nullable();
            $table->string('deleted_reason', 500)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down(): void
    {
        Schema::table('funnels', function (Blueprint $table) {
            $table->dropColumn('deleted_reason');
            $table->dropSoftDeletes();
        });
    }
};
