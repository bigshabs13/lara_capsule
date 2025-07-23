<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        // Get only the titles (or first 30 chars) of the user's capsules
        $capsuleTitles = $user->capsules()->pluck('message', 'id')->map(function($msg) {
            return mb_strimwidth($msg, 0, 30, '...');
        });

        return response()->json([
            'user' => $user,
            'capsule_titles' => $capsuleTitles
        ]);
    }
}
