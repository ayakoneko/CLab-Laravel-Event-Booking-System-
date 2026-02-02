<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id=$request->user()->id;

        $reports = DB::select("
            SELECT e.id, e.title, e.starts_at, e.capacity,
                COUNT(DISTINCT b.id) AS booking,
                GREATEST(e.capacity - COUNT(DISTINCT b.id), 0) AS remaining,
                COUNT(DISTINCT w.id) AS waiting
            FROM events AS e
            LEFT JOIN bookings AS b ON e.id = b.event_id AND b.status = 'confirmed'
            LEFT JOIN waitlists AS w ON e.id = w.event_id
            WHERE e.organiser_id = ?
            GROUP BY e.id, e.title, e.starts_at, e.capacity
            ORDER BY e.starts_at ASC
        ", [$user_id]);


        return Inertia::render('Dashboard/Index', [
            'reports' => $reports,
            'user' => $request->user()
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
    public function store(Request $request)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
