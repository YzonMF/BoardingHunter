<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use Illuminate\Console\Command;

class ExpireReservations extends Command
{
    protected $signature = 'reservations:expire';

    protected $description = 'Expire approved reservations older than their 7-day hold and free the rooms';

    public function handle(): int
    {
        $count = Reservation::expireOverdue();

        $this->info("Expired {$count} reservation(s).");

        return self::SUCCESS;
    }
}
