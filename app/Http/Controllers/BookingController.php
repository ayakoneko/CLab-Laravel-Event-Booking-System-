<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\Booking;
use App\Models\Event;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request )
    {
        $user = $request->user();

        $bookings = Booking::where('user_id', $user->id)
                ->where('status', 'confirmed')
                ->with('event')
                ->orderBy(Event::select('starts_at')->whereColumn('events.id', 'bookings.event_id'))
                ->get();

        return Inertia::render('Bookings/Index', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $user = $request->user();
        $user_id = $user -> id;

        // Validation Check (Duplicate/Capacity)
        // $request->validate([
        //     $user_id => [
        //         Rule::unique('bookings')
        //             ->where(fn($query) => $query->where('event_id', $event->id)->where('status', 'confirmed')),
        //     ],
        // ], ['user_id.unique' => 'You already booked this event.']);

        // if ($event->isFull()) {
        //     return back()->withErrors(['capacity' => 'Sorry, this event is full.']);
        // }

        Booking::create([
            'event_id' => $event -> id,
            'user_id' => $user -> id,
            'status' => 'confirmed',
            'ticket_code' => Str::upper(Str::random(8)),
        ]);

        return redirect()->route('bookings.index', $event)->with('success', 'Booking confirmed successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        if ($booking->status === 'confirmed') {
        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
    }

    return back()->with('success', 'Booking cancelled successfully.');

    }
}
