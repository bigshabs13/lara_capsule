<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Capsule;

class CapsuleController extends Controller
{
    /**
     * Store a newly created capsule in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'gps_latitude' => 'required|numeric',
            'gps_longitude' => 'required|numeric',
            'mood_id' => 'nullable|exists:moods,id',
            'reveal_at' => 'required|date|after:now',
            'is_public' => 'boolean',
        ]);

        Capsule::create([
            'user_id' => $request->user()->id,
            'message' => $request->message,
            'gps_latitude' => $request->gps_latitude,
            'gps_longitude' => $request->gps_longitude,
            'ip_address' => $request->ip(),
            'mood_id' => $request->mood_id,
            'is_public' => $request->is_public ?? true,
            'reveal_at' => $request->reveal_at,
            'country' => $this->getCountryFromLocation($request->gps_latitude, $request->gps_longitude),
        ]);

        return response()->json(['message' => 'Capsule created successfully.'], 201);
    }

    /**
     * Display the specified capsule.
     */
    public function show($id)
    {
        $capsule = Capsule::findOrFail($id);

        if (now()->lt($capsule->reveal_at)) {
            // Return countdown
            return response()->json([
                'countdown' => $capsule->reveal_at->diffForHumans()
            ]);
        }

        // Mark as revealed if not already
        if (!$capsule->revealed_at) {
            $capsule->revealed_at = now();
            $capsule->save();
        }

        return response()->json($capsule);
    }

    /**
     * Display a listing of public, revealed capsules with optional filters.
     */
    public function publicWall(Request $request)
    {
        $query = Capsule::where('is_public', true)
            ->where('reveal_at', '<=', now());

        if ($request->country) {
            $query->where('country', $request->country);
        }
        if ($request->mood_id) {
            $query->where('mood_id', $request->mood_id);
        }
        if ($request->time_from && $request->time_to) {
            $query->whereBetween('reveal_at', [$request->time_from, $request->time_to]);
        }

        $capsules = $query->get();
        return response()->json($capsules);
    }

    // You can add other resource methods (index, edit, update, destroy) as needed, but leave them empty or implement as required.

    private function getCountryFromLocation($lat, $lng)
    {
        // TODO: Implement real geolocation lookup.
        return 'Unknown';
    }
}