<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = \App\Models\Event::with(['category', 'performers'])->latest()->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        $performers = \App\Models\Performer::all();
        return view('admin.events.create', compact('categories', 'performers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'date'         => 'required|date',
            'time'         => 'required',
            'venue'        => 'required|string|max:255',
            'ticket_price' => 'required|numeric|min:0',
            'capacity'     => 'required|integer|min:0',
            'category_id'  => 'required|exists:categories,id',
            'image_file'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_url'    => 'nullable|url',
            'performers'   => 'required|array',
            'performers.*' => 'exists:performers,id',
        ]);

        $data = $request->except(['performers', 'image_file']);

        // File upload takes priority over URL
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('events', 'public');
            $data['image_url'] = Storage::url($path);
        }

        $event = \App\Models\Event::create($data);
        $event->performers()->attach($request->performers);

        Cache::forget('event_listings');
        Cache::forget('api_events_index');

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(\App\Models\Event $event)
    {
        $categories = \App\Models\Category::all();
        $performers = \App\Models\Performer::all();
        $event->load('performers');
        return view('admin.events.edit', compact('event', 'categories', 'performers'));
    }

    public function update(Request $request, \App\Models\Event $event)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'date'         => 'required|date',
            'time'         => 'required',
            'venue'        => 'required|string|max:255',
            'ticket_price' => 'required|numeric|min:0',
            'capacity'     => 'required|integer|min:0',
            'category_id'  => 'required|exists:categories,id',
            'image_file'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_url'    => 'nullable|url',
            'performers'   => 'required|array',
            'performers.*' => 'exists:performers,id',
        ]);

        $data = $request->except(['performers', 'image_file']);

        // File upload takes priority over URL
        if ($request->hasFile('image_file')) {
            // Delete old uploaded file if it exists in storage
            if ($event->image_url && str_starts_with($event->image_url, '/storage/')) {
                $oldPath = str_replace('/storage/', 'public/', $event->image_url);
                Storage::delete($oldPath);
            }
            $path = $request->file('image_file')->store('events', 'public');
            $data['image_url'] = Storage::url($path);
        }

        $event->update($data);
        $event->performers()->sync($request->performers);

        Cache::forget('event_listings');
        Cache::forget('api_events_index');

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(\App\Models\Event $event)
    {
        // Clean up uploaded file if any
        if ($event->image_url && str_starts_with($event->image_url, '/storage/')) {
            $oldPath = str_replace('/storage/', 'public/', $event->image_url);
            Storage::delete($oldPath);
        }

        $event->delete();
        Cache::forget('event_listings');
        Cache::forget('api_events_index');
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}
