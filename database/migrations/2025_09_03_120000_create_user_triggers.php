<?php
// 2025_09_03_120000_create_user_triggers.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // All tables (users, admins, owners, seekers) now exist
        DB::unprepared('
            CREATE TRIGGER after_user_insert
            AFTER INSERT ON users
            FOR EACH ROW
            BEGIN
                IF NEW.role = "roomOwner" THEN
                    INSERT INTO owners (UserID, BusinessName) VALUES (NEW.UserID, NULL);
                ELSEIF NEW.role = "roomSeeker" THEN
                    INSERT INTO seekers (UserID, Preferences) VALUES (NEW.UserID, NULL);
                ELSEIF NEW.role = "admin" THEN
                    INSERT INTO admins (UserID, AccessLevel) VALUES (NEW.UserID, "standard");
                END IF;
            END
        ');

        DB::unprepared('
            CREATE TRIGGER after_user_update
            AFTER UPDATE ON users
            FOR EACH ROW
            BEGIN
                IF OLD.role != NEW.role THEN
                    -- Remove from old role table
                    IF OLD.role = "roomOwner" THEN
                        DELETE FROM owners WHERE UserID = OLD.UserID;
                    ELSEIF OLD.role = "roomSeeker" THEN
                        DELETE FROM seekers WHERE UserID = OLD.UserID;
                    ELSEIF OLD.role = "admin" THEN
                        DELETE FROM admins WHERE UserID = OLD.UserID;
                    END IF;
                    
                    -- Add to new role table
                    IF NEW.role = "roomOwner" THEN
                        INSERT INTO owners (UserID, BusinessName) VALUES (NEW.UserID, NULL);
                    ELSEIF NEW.role = "roomSeeker" THEN
                        INSERT INTO seekers (UserID, Preferences) VALUES (NEW.UserID, NULL);
                    ELSEIF NEW.role = "admin" THEN
                        INSERT INTO admins (UserID, AccessLevel) VALUES (NEW.UserID, "standard");
                    END IF;
                END IF;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_user_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS after_user_update');
    }
};