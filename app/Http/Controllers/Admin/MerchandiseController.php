<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MerchandiseController extends Controller
{
    public function index()
    {
        $merchandises = \App\Models\Merchandise::latest()->get();
        return view('admin.merchandise.index', compact('merchandises'));
    }

    public function create()
    {
        return view('admin.merchandise.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|url',
        ]);

        \App\Models\Merchandise::create($request->all());
        Cache::forget('merchandise_listings');

        return redirect()->route('admin.merchandise.index')->with('success', 'Merchandise created successfully.');
    }

    public function edit(\App\Models\Merchandise $merchandise)
    {
        return view('admin.merchandise.edit', compact('merchandise'));
    }

    public function update(Request $request, \App\Models\Merchandise $merchandise)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|url',
        ]);

        $merchandise->update($request->all());
        Cache::forget('merchandise_listings');

        return redirect()->route('admin.merchandise.index')->with('success', 'Merchandise updated successfully.');
    }

    public function destroy(\App\Models\Merchandise $merchandise)
    {
        $merchandise->delete();
        Cache::forget('merchandise_listings');
        return redirect()->route('admin.merchandise.index')->with('success', 'Merchandise deleted successfully.');
    }
}
