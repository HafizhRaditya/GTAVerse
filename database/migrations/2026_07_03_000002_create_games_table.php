<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('universe', ['3D', 'HD']);
            $table->date('release_date')->nullable();
            $table->string('platforms')->nullable();
            $table->string('setting')->nullable();          // contoh: "Vice City, 1986"
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('theme_color', 20)->default('#ff2ea6');
            $table->string('accent_color', 20)->default('#7c3aed');
            $table->boolean('is_featured')->default(false); // tampil di hero slider & scroll journey
            $table->enum('status', ['released', 'upcoming'])->default('released');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
