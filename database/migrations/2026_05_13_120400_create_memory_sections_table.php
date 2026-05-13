<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memory_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memory_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['story','timeline','quote','video'])->default('story');
            $table->string('label')->nullable();                // eyebrow e.g. "Buổi sáng đầu tiên"
            $table->string('heading')->nullable();              // supports <em> HTML
            $table->longText('content')->nullable();
            $table->string('handwritten_note')->nullable();     // italic Caveat note
            $table->string('image')->nullable();
            $table->string('image_tag')->nullable();            // overlay e.g. "09:00 · Sáng"
            $table->boolean('image_right')->default(false);
            $table->string('time_label')->nullable();           // for timeline type
            $table->string('video_url')->nullable();            // for video type
            $table->string('quote_author')->nullable();         // for quote type
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->index(['memory_id','sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memory_sections');
    }
};

