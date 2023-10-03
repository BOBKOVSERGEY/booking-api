<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use Illuminate\Auth\Access\AuthorizationException;

class BookingController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index()
    {
      $this->authorize('bookings-manage');

        // Will implement booking management later
        return response()->json(['success' => true]);
    }

    public function store(StoreBookingRequest $request)
    {
        $booking = auth()
            ->user()
            ->bookings()
            ->create($request->validated());

        return new BookingResource($booking);
    }
}
