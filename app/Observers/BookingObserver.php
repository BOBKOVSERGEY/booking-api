<?php

namespace App\Observers;

use App\Models\Booking;

class BookingObserver
{
    // before save
    public function creating(Booking $booking): void
    {
        $booking->total_price = $booking->apartment->calculatePriceForDates(
            $booking->start_date,
            $booking->end_date
        );
    }
}
