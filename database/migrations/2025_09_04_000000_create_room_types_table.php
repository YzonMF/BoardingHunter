<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Accommodation types (Boarding, Transient, Hotel, ...). Admins add, rename and
     * remove them from the admin panel, so a new type needs no code change.
     */
    public function up(): void
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->bigIncrements('RoomTypeID');
            $table->string('name', 50)->unique();
            $table->unsignedSmallInteger('sort_order')->default(0);
        });

        // The types the app started with, so listings can be created right away.
        DB::table('room_types')->insert([
            ['name' => 'Boarding', 'sort_order' => 1],
            ['name' => 'Transient', 'sort_order' => 2],
            ['name' => 'Hotel', 'sort_order' => 3],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
