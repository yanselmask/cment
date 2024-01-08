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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')
                ->fulltext();
            $table->string('slug');
            $table->string('template')
                ->default('default');
            $table->text('content')
                ->fulltext()
                ->nullable();
            $table->text('editorjs_blocks')
                ->fulltext()
                ->nullable();
            $table->text('gjs_data')
                ->fulltext()
                ->nullable();
            $table->foreignId('user_id')
                ->nullable();
            $table->tinyInteger('status')
                ->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
