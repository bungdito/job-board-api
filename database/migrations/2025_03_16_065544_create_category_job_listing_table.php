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
        Schema::create('category_job_listing', function (Blueprint $table) {
            $table->foreignId('job_listing_id')->constrained('job_listings')->onDelete('cascade');
            $table->index(['job_listing_id', 'category_id']); // Foreign key to job_listings
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Foreign key to categories
            $table->primary(['job_listing_id', 'category_id']);
            $table->timestamps(); // Created_at & Updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_job_listing');
    }
};
