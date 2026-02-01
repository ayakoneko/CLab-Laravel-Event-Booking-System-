<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use Inertia\Inertia;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Events/Index', [
            'events' => Event::where('starts_at', '>=', now())
                ->orderBy('starts_at')
                ->paginate(8),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $event = new Event();
        return Inertia::render('Events/Create_form', [
            'event' => $event,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'starts_at' => 'required|date|date_format:Y-m-d\TH:i|after:now',
            'ends_at' => 'nullable|date|date_format:Y-m-d\TH:i|after_or_equal:starts_at',
            'is_online' => 'required|boolean',
            'location' => 'required_if:is_online,0|nullable|string|max:255',
            'online_url' => 'required_if:is_online,1|nullable|url|max:255',
            'capacity' => 'required|integer|min:1|max:1000',
            'price_cents' => 'required|integer|min:0',
            'image_path' => 'nullable|string|max:2048',
        ],[
            'starts_at.after'   => 'The start time must be in the future.',
            'ends_at.after_or_equal' => 'The end time must be after the start time.',
            'location.required_if'   => 'Location is required for in-person events.',
            'online_url.required_if' => 'Online URL is required when the event is online.',
        ]);

        if ($request->boolean('is_online')) {
            $validatedData['location'] = 'Online';
        }

        $validatedData['organiser_id'] = Auth::id();

        $event = Event::create($validatedData);
        return redirect()->route('events.show', $event)->with('success', 'Event created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return Inertia::render('Events/Show', [
            'event' => $event->load('organiser'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //creator-only
        abort_unless($event->organiser_id === Auth::id(), 403);

        return Inertia::render('Events/Update_form', [
            'event' => $event,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'starts_at' => 'required|date|date_format:Y-m-d\TH:i|after:now',
            'ends_at' => 'nullable|date|date_format:Y-m-d\TH:i|after_or_equal:starts_at',
            'is_online' => 'required|boolean',
            'location' => 'required_if:is_online,0|nullable|string|max:255',
            'online_url' => 'required_if:is_online,1|nullable|url|max:255',
            'capacity' => 'required|integer|min:1|max:1000',
            'price_cents' => 'required|integer|min:0',
            'image_path' => 'nullable|string|max:2048',
        ],[
            'starts_at.after'   => 'The start time must be in the future.',
            'ends_at.after_or_equal' => 'The end time must be after the start time.',
            'location.required_if'   => 'Location is required for in-person events.',
            'online_url.required_if' => 'Online URL is required when the event is online.',
        ]);

        if ($request->boolean('is_online')) {
            $validatedData['location'] = 'Online';
        }

        $event->update($validatedData);
        return redirect()->route('events.show', $event)->with('success', 'Event updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //creator only
        abort_unless($event->organiser_id === Auth::id(), 403);

        $event->delete();
        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }
}
