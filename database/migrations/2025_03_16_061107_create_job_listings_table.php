<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('company_name');
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->boolean('is_remote')->default(false);
            $table->enum('job_type', ['full-time', 'part-time', 'contract', 'freelance']);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->index('company_name');
            $table->timestamps();

            $table->index(['published_at', 'job_type', 'status', 'salary_min', 'salary_max', 'is_remote'], 'job_listings_filter_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
