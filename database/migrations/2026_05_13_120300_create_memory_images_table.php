<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memory_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memory_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('caption')->nullable();
            $table->string('handwritten_caption')->nullable();  // shown in scrapbook theme
            $table->enum('type', ['gallery','hero','thumbnail'])->default('gallery');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->index(['memory_id','type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memory_images');
    }
};

