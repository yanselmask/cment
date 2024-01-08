<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')
                ->fulltext();
            $table->string('slug');
            $table->string('template')
                ->default('default');
            $table->string('excerpt')
                ->fulltext()
                ->nullable();
            $table->text('content')
                ->fulltext()
                ->nullable();
            $table->text('editorjs_blocks')
                ->fulltext()
                ->nullable();
            $table->foreignId('user_id')
                ->nullable();
            $table->string('main_image')
                ->nullable();
            $table->tinyInteger('status')
                ->default(1);
            $table->boolean('is_featured')
                ->default(false);
            $table->boolean('is_sponsored')
                ->default(false);
            $table->boolean('allowed_comment')
                ->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
