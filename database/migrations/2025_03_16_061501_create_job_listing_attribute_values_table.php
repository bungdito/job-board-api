<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_listing_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_listing_id')->constrained('job_listings')->onDelete('cascade');
            $table->foreignId('attribute_id')->constrained('attributes')->onDelete('cascade');
            $table->text('value');
            $table->timestamps();

            $table->index(['job_listing_id', 'attribute_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listing_attribute_values');
    }
};
