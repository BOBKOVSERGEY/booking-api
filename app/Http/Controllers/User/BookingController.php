<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;

class BookingController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index()
    {
      $this->authorize('bookings-manage');

        $bookings = auth()->user()->bookings()
            ->with('apartment.property')
            ->withTrashed()
            ->orderBy('start_date')
            ->get();

        return BookingResource::collection($bookings);
    }

    public function store(StoreBookingRequest $request): BookingResource
    {
        $booking = auth()
            ->user()
            ->bookings()
            ->create($request->validated());

        return new BookingResource($booking);
    }

    public function show(Booking $booking): BookingResource
    {
        $this->authorize('bookings-manage');

        if ($booking->user_id != auth()->id()) {
            abort(403);
        }

        return new BookingResource($booking);
    }

    public function destroy(Booking $booking): Response
    {
        $this->authorize('bookings-manage');

        if ($booking->user_id != auth()->id()) {
            abort(403);
        }

        $booking->delete();

        return response()->noContent();
    }
}
