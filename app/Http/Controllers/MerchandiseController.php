<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MerchandiseController extends Controller
{
    /**
     * Display a listing of the merchandise.
     */
    public function index()
    {
        // Implement caching for merchandise listings as per performance requirements
        $merchandise = Cache::remember('merchandise_listings', 3600, function () {
            return Merchandise::all();
        });

        return response()->json([
            'status' => 1,
            'data' => $merchandise
        ]);
    }

    /**
     * Display the specified merchandise.
     */
    public function show($id)
    {
        $item = Merchandise::find($id);

        if (!$item) {
            return response()->json([
                'status' => 0,
                'message' => 'Merchandise not found'
            ], 404);
        }

        return response()->json([
            'status' => 1,
            'data' => $item
        ]);
    }
}
