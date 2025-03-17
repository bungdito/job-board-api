<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_listing_language', function (Blueprint $table) {
            $table->foreignId('job_listing_id')->constrained('job_listings')->onDelete('cascade');
            $table->foreignId('language_id')->constrained('languages')->onDelete('cascade');
            $table->primary(['job_listing_id', 'language_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listing_language');
    }
};