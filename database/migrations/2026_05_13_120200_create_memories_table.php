<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->date('memory_date')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('background_music')->nullable();
            $table->text('opening_quote')->nullable();
            $table->string('opening_quote_author')->nullable();
            $table->string('template')->default('classic');     // classic|scrapbook|film|minimal
            $table->string('color_accent')->nullable();         // hex e.g. #c9847a
            $table->string('password')->nullable();             // bcrypt; null = public
            $table->boolean('published')->default(false);
            $table->integer('sort_order')->default(0);
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memories');
    }
};

