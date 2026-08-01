<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('needs_vest')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('registrations');
    }
};
