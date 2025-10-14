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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->unsignedBigInteger('UserID')->primary();
            $table-> int ('Seeker Id');
            $table -> int('Owner id');
            $table-> text('Message');
            $table-> DATETIME('Datasent');
            $table-> ENUM('Status'['Pending' "Replied"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
