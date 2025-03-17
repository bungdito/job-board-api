<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country');
            $table->timestamps();

            $table->index(['city']);
            $table->index(['country']);
            $table->index(['city', 'state', 'country']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
