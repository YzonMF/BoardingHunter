<?php

namespace Database\Seeders;

use App\Models\Accommodation;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with demo accounts and listings.
     * All demo accounts use the password "password".
     *
     * The owners/seekers/admins rows are created by the users table triggers.
     */
    public function run(): void
    {
        $this->user('Admin User', 'admin@boardinghunter.test', 'admin');
        $owner = $this->user('Olivia Owner', 'owner@boardinghunter.test', 'roomOwner');
        $owner2 = $this->user('Oscar Owner', 'owner2@boardinghunter.test', 'roomOwner');
        $this->user('Sam Seeker', 'seeker@boardinghunter.test', 'roomSeeker');
        $this->user('Sofia Seeker', 'seeker2@boardinghunter.test', 'roomSeeker');

        $listings = [
            [$owner, 'Sunrise Boarding House', 'Boarding', 'Clean shared rooms near the university, with Wi-Fi and a common kitchen.', 'Tagum City', 450, 6500],
            [$owner, 'Cozy Studio Transient', 'Transient', 'Private studio with aircon and a small kitchenette, good for short stays.', 'Davao City', 1200, 18000],
            [$owner, 'Lakeview Room', 'Boarding', 'Quiet single room, 5 minutes from the public market.', 'Tagum City', 600, 8500],
            [$owner2, 'Grand Plaza Hotel', 'Hotel', 'Standard hotel room with breakfast, 24/7 front desk and parking.', 'Davao City', 2500, 45000],
            [$owner2, 'Student Haven Dorm', 'Boarding', 'Bunk-style dorm with study area, near jeepney routes.', 'Mati City', 350, 5000],
            [$owner2, 'Garden Transient Home', 'Transient', 'Whole-house transient with a garden, sleeps up to six.', 'Mati City', 1800, 26000],
        ];

        foreach ($listings as $i => [$o, $name, $type, $description, $location, $night, $month]) {
            $accommodation = Accommodation::create([
                'OwnerID' => $o->UserID,
                'Name' => $name,
                'Type' => $type,
                'Description' => $description,
                'Location' => $location,
                'PricePerNight' => $night,
                'PricePerMonth' => $month,
                'status' => 'active',
            ]);

            Photo::create([
                'AccommodationID' => $accommodation->AccommodationID,
                'FilePathURL' => 'https://picsum.photos/seed/boardinghunter' . ($i + 1) . '/800/600',
                'Caption' => $name,
            ]);
        }
    }

    private function user(string $fullname, string $email, string $role): User
    {
        return User::create([
            'fullname' => $fullname,
            'email' => $email,
            'password' => Hash::make('password'),
            'contactnum' => '09123456789',
            'role' => $role,
        ]);
    }
}
