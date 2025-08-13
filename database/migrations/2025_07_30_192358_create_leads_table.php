<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('niche_category')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->foreignId('funnel_id')->nullable()->constrained()->nullOnDelete();
            $table->string('source');
            $table->enum('source_type', ['organic', 'ads', 'referral', 'manual'])->nullable(); 
            $table->enum('status', ['new', 'contacted', 'qualified', 'converted'])->default('new');
            $table->decimal('pays', 10, 2)->nullable();
            $table->foreignId('client_id')->nullable()->constrained()->nullOnDelete();
            $table->json('lead_belongs_to')->nullable();
            $table->json('metadata')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('contacted_at')->nullable();
            $table->timestamp('converted_at')->nullable();
            $table->boolean('is_test')->default(false);
            $table->longText('deleted_reason')->nullable();
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
