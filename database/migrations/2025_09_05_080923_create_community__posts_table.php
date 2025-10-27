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
        Schema::create('community_posts', function (Blueprint $table) {
            $table->bigIncrements('PostID');
            $table->unsignedBigInteger('UserID'); // define it first
            $table->string('Title', 150);
            $table->text('Content');
            $table->timestamp('PostDate')->useCurrent();

            // then add the foreign key
            $table->foreign('UserID')
                  ->references('UserID')
                  ->on('owners')
                  ->onDelete('cascade');
        });
    }

    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_posts');
    }
};
