<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('UserID');
            $table->string('fullname', 50);
            $table->string('email', 50)->unique();
            $table->string('password');
            $table->string('contactnum', 50);
            $table->enum('Role', ['admin', 'roomSeeker', 'roomOwner']);
            $table->timestamp('dateJoined')->useCurrent();
        });

        // Create trigger for automatic table population based on Role
        DB::unprepared('
            CREATE TRIGGER after_user_insert
            AFTER INSERT ON users
            FOR EACH ROW
            BEGIN
                IF NEW.Role = "roomOwner" THEN
                    INSERT INTO owners (UserID, BusinessName) VALUES (NEW.UserID, NULL);
                ELSEIF NEW.Role = "roomSeeker" THEN
                    INSERT INTO seekers (UserID, Preferences) VALUES (NEW.UserID, NULL);
                ELSEIF NEW.Role = "admin" THEN
                    INSERT INTO admins (UserID, AccessLevel) VALUES (NEW.UserID, "standard");
                END IF;
            END
        ');

        // Optional: Create trigger for handling role updates
        DB::unprepared('
            CREATE TRIGGER after_user_update
            AFTER UPDATE ON users
            FOR EACH ROW
            BEGIN
                IF OLD.Role != NEW.Role THEN
                    -- Remove from old role table
                    IF OLD.Role = "roomOwner" THEN
                        DELETE FROM owners WHERE UserID = OLD.UserID;
                    ELSEIF OLD.Role = "roomSeeker" THEN
                        DELETE FROM seekers WHERE UserID = OLD.UserID;
                    ELSEIF OLD.Role = "admin" THEN
                        DELETE FROM admins WHERE UserID = OLD.UserID;
                    END IF;
                    
                    -- Add to new role table
                    IF NEW.Role = "roomOwner" THEN
                        INSERT INTO owners (UserID, BusinessName) VALUES (NEW.UserID, NULL);
                    ELSEIF NEW.Role = "roomSeeker" THEN
                        INSERT INTO seekers (UserID, Preferences) VALUES (NEW.UserID, NULL);
                    ELSEIF NEW.Role = "admin" THEN
                        INSERT INTO admins (UserID, AccessLevel) VALUES (NEW.UserID, "standard");
                    END IF;
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_user_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS after_user_update');
        
        Schema::dropIfExists('admins');
        Schema::dropIfExists('seekers');
        Schema::dropIfExists('owners');
        Schema::dropIfExists('users');
    }
};