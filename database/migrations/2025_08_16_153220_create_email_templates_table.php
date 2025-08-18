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
        Schema::create('email_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "Welcome Drip Email 1"
            $table->string('subject');
            $table->longText('body_html'); // store HTML version
            $table->longText('body_text')->nullable(); // fallback plain text version
            $table->enum('category', ['welcome', 'follow_up', 'promo', 'reminder', 'newsletter'])->default('welcome');
            $table->boolean('is_default')->default(false); // mark system templates
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sys_email_template_id')->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_templates', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('email_templates');
    }
};
