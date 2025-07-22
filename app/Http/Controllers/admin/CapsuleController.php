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
     * Display a paginated, filtered listing of all capsules.
     */
    public function index(Request $request)
    {
        $query = Capsule::query();

        if ($request->has('country')) {
            $query->where('country', $request->country);
        }
        if ($request->has('mood_id')) {
            $query->where('mood_id', $request->mood_id);
        }
        if ($request->has('from') && $request->has('to')) {
            $query->whereBetween('reveal_at', [$request->from, $request->to]);
        }

        $perPage = $request->get('per_page', 10);
        $capsules = $query->paginate($perPage);
        return response()->json($capsules);
    }

    /**
     * Display a paginated, filtered listing of public, revealed capsules.
     */
    public function publicWall(Request $request)
    {
        $query = Capsule::where('is_public', true)
            ->where('reveal_at', '<=', now());

        if ($request->has('country')) {
            $query->where('country', $request->country);
        }
        if ($request->has('mood_id')) {
            $query->where('mood_id', $request->mood_id);
        }
        if ($request->has('from') && $request->has('to')) {
            $query->whereBetween('reveal_at', [$request->from, $request->to]);
        }

        $perPage = $request->get('per_page', 10);
        $capsules = $query->paginate($perPage);
        return response()->json($capsules);
    }
}