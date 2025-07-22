<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Capsule;
use Stevebauman\Location\Facades\Location;

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

        $position = Location::get($request->ip());
        $country = ($position && $position->countryName) ? $position->countryName : 'Unknown';

        Capsule::create([
            'user_id' => $request->user()->id,
            'message' => $request->message,
            'gps_latitude' => $request->gps_latitude,
            'gps_longitude' => $request->gps_longitude,
            'ip_address' => $request->ip(),
            'mood_id' => $request->mood_id,
            'is_public' => $request->is_public ?? true,
            'reveal_at' => $request->reveal_at,
            'country' => $country,
        ]);

        return response()->json(['message' => 'Capsule created successfully.'], 201);
    }

    public function create()
    {
        return view('capsules.create');
    }

    /* Display the specified capsule. */
    public function show($id)
    {
        $capsule = Capsule::findOrFail($id);
        return response()->json($capsule);
    }

    /**
     * Display a listing of all capsules.
     */
    public function index()
    {
        return response()->json(Capsule::all());
    }

    public function publicWall(Request $request)
    {
        $capsules = Capsule::where('is_public', true)
            ->where('reveal_at', '<=', now())
            ->get();
        return view('capsules.public_wall', compact('capsules'));
    }

    /**
     * Update the specified capsule.
     */
    public function update(Request $request, $id)
    {
        $capsule = Capsule::findOrFail($id);
        if ($capsule->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $request->validate([
            'message' => 'sometimes|string|max:500',
            'gps_latitude' => 'sometimes|numeric',
            'gps_longitude' => 'sometimes|numeric',
            'mood_id' => 'nullable|exists:moods,id',
            'reveal_at' => 'sometimes|date|after:now',
            'is_public' => 'boolean',
        ]);
        $capsule->update($request->only([
            'message', 'gps_latitude', 'gps_longitude', 'mood_id', 'is_public', 'reveal_at'
        ]));
        return response()->json(['message' => 'Capsule updated successfully.', 'capsule' => $capsule]);
    }

    /**
     * Remove the specified capsule.
     */
    public function destroy(Request $request, $id)
    {
        $capsule = Capsule::findOrFail($id);
        if ($capsule->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $capsule->delete();
        return response()->json(['message' => 'Capsule deleted successfully.']);
    }
}