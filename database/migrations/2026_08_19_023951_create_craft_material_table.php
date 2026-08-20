<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('craft_material', function (Blueprint $table) {
            $table->id();

            $table->foreignId('craft_id')
                ->constrained('crafts')
                ->cascadeOnDelete();

            $table->foreignId('material_id')
                ->constrained('materials')
                ->cascadeOnDelete();

            $table->unique(['craft_id', 'material_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('craft_material');
    }
};
