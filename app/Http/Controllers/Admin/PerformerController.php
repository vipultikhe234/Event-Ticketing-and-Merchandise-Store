<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PerformerController extends Controller
{
    public function index()
    {
        $performers = \App\Models\Performer::with('category')->latest()->get();
        return view('admin.performers.index', compact('performers'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.performers.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'spotify_id' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|url',
        ]);

        \App\Models\Performer::create($request->all());

        return redirect()->route('admin.performers.index')->with('success', 'Performer created successfully.');
    }

    public function edit(\App\Models\Performer $performer)
    {
        $categories = \App\Models\Category::all();
        return view('admin.performers.edit', compact('performer', 'categories'));
    }

    public function update(Request $request, \App\Models\Performer $performer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'spotify_id' => 'nullable|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|url',
        ]);

        $performer->update($request->all());

        return redirect()->route('admin.performers.index')->with('success', 'Performer updated successfully.');
    }

    public function destroy(\App\Models\Performer $performer)
    {
        $performer->delete();
        return redirect()->route('admin.performers.index')->with('success', 'Performer deleted successfully.');
    }
}
