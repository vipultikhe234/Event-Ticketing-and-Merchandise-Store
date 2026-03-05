<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Performer;
use App\Services\SpotifyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Validates and registers a new performer, including optional bio, Spotify ID, and profile image upload.
     * Saves the performer data in the database and stores the uploaded image in the public directory.
     * Returns a JSON response with the performer details upon successful registration or validation errors if any.
     */
    public function registerPerformer(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'bio' => 'nullable|string',
                'category_id' => 'nullable|integer|exists:categories,id',
                'spotify_id' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "status" => 0,
                    "message" => $validator->errors()
                ], 422);
            }
            $imageName = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $imageName = 'performer_' . uniqid() . '.' . $extension;
                $uploadPath = public_path('uploads/performer/');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                $file->move($uploadPath, $imageName);
                $imageName = 'uploads/performer/' . $imageName;
            }
            $performer = Performer::create([
                'name' => $request->name,
                'bio' => $request->bio,
                'category_id' => $request->category_id,
                'spotify_id' => $request->spotify_id,
                'image' => $imageName
            ]);

            return response()->json([
                'status' => 1,
                'message' => 'Performer registered successfully',
                'data' => $performer
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validates and creates a new event with title, description, date, time, venue, ticket price, and associated performer.
     * Saves the event in the database and ensures the performer exists.
     * Returns a JSON response with the event details upon success or an error message if validation fails or an exception occurs.
     */

    public function registerEvent(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'date' => 'required|date',
                'time' => 'required',
                'venue' => 'required|string|max:255',
                'ticket_price' => 'required|numeric|min:0',
                'category_id' => 'nullable|integer|exists:categories,id',
                'performer_id' => 'required|integer|exists:performers,id',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 0,
                    'message' => $validator->errors()
                ], 422);
            }
            $event = Event::create([
                'title' => $request->title,
                'description' => $request->description,
                'date' => $request->date,
                'time' => $request->time,
                'venue' => $request->venue,
                'ticket_price' => $request->ticket_price,
                'category_id' => $request->category_id,
                'performer_id' => $request->performer_id,
            ]);

            // Sync the primary performer to the pivot table for many-to-many support
            $event->performers()->sync([$request->performer_id]);
            return response()->json([
                'status' => 1,
                'message' => 'Event created successfully',
                'data' => $event
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retrieves all events and the currently authenticated user.
     * Passes the events and user data to the dashboard view.
     * Returns the rendered dashboard view with the provided data.
     */
    public function dashboard()
    {
        // Caching event listings for 1 hour to improve performance
        $events = Cache::remember('event_listings', 3600, function () {
            return Event::with('performer', 'category')->get();
        });

        $merchandises = Cache::remember('merchandise_listings', 3600, function () {
            return \App\Models\Merchandise::all();
        });

        $user = auth()->user();
        return view('dashboard', compact('events', 'user', 'merchandises'));
    }

    /**
     * Retrieves a specific event along with its associated performer.
     * If the performer has a Spotify ID, fetches their top tracks using the SpotifyService.
     * Returns a JSON response with event details, performer info, and top tracks or an error if the event is not found.
     */
    public function getEventWithPerformer($id, SpotifyService $spotify)
    {
        $event = Event::with('performer', 'category')->find($id);

        if (!$event) {
            return response()->json([
                "status" => 0,
                "message" => "Event not found"
            ], 404);
        }
        $performerTracks = [];

        if ($event->performer) {
            $performerTracks = $event->performer->spotify_id
                ? $spotify->getTopTracksByArtist($event->performer->spotify_id)
                : [];
        }

        return response()->json([
            'status' => 1,
            'event' => $event,
            'performer' => $event->performer,
            'performer_tracks' => $performerTracks
        ]);
    }

    /**
     * RESTful API: Get all events
     */
    public function apiIndex()
    {
        return Cache::remember('api_events_index', 3600, function () {
            return \App\Http\Resources\EventResource::collection(Event::with('performer', 'category')->get());
        });
    }

    /**
     * RESTful API: Get specific event
     */
    public function apiShow($id)
    {
        $event = Event::with('performer', 'category')->find($id);
        if (!$event) {
            return response()->json(['message' => 'Not found'], 404);
        }
        return new \App\Http\Resources\EventResource($event);
    }
}
