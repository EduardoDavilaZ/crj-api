<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_age_range', function (Blueprint $table) {
            $table->id();

            $table->foreignId('activity_id')
                ->constrained('activities')
                ->cascadeOnDelete();

            $table->foreignId('age_range_id')
                ->constrained('age_ranges')
                ->cascadeOnDelete();

            $table->unique(['activity_id', 'age_range_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_age_range');
    }
};
