<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->longText('instructions');

            $table->foreignId('activity_type_id')
                ->constrained('activity_types')
                ->restrictOnDelete();

            $table->unsignedInteger('participants_min')->nullable();
            $table->unsignedInteger('participants_max')->nullable();

            $table->string('image_url')->nullable();
            $table->string('source_url')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
