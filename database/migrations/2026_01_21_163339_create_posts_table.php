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
        
        // Foreign Key: Links to the User who wrote it
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Foreign Key: Links to the Category (Note: nullable allows "Uncategorized" posts)
        $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

        $table->string('title');
        $table->string('slug')->unique();
        $table->text('excerpt')->nullable();
        $table->longText('body');
        $table->string('featured_image')->nullable();
        
        // Publishing controls
        $table->boolean('is_published')->default(false);
        $table->timestamp('published_at')->nullable();

        $table->timestamps();
        $table->softDeletes(); // logical deletion
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
