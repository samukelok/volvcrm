<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_status_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained()->cascadeOnDelete();
            $table->enum('from_status', ['new', 'contacted', 'qualified', 'converted']);
            $table->enum('to_status', ['new', 'contacted', 'qualified', 'converted']);
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Optional: who made the change
            $table->timestamp('changed_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_status_changes');
    }
};