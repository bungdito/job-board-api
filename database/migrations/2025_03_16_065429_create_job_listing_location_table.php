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
        Schema::create('job_listing_location', function (Blueprint $table) {
            $table->foreignId('job_listing_id')->constrained('job_listings')->onDelete('cascade');
            $table->index(['job_listing_id', 'location_id']); // Foreign key to job_listings
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade'); // Foreign key to locations
            $table->primary(['job_listing_id', 'location_id']);
            $table->timestamps(); // Created_at & Updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listing_location');
    }
};
