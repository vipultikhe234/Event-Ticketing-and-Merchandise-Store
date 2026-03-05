<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiscountCodeController extends Controller
{
    public function index()
    {
        $discountCodes = \App\Models\DiscountCode::latest()->get();
        return view('admin.discount_codes.index', compact('discountCodes'));
    }

    public function create()
    {
        return view('admin.discount_codes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:discount_codes,code',
            'percentage' => 'required|integer|min:0|max:100',
            'expires_at' => 'nullable|date',
            'single_use' => 'boolean',
        ]);

        \App\Models\DiscountCode::create([
            'code' => strtoupper($request->code),
            'percentage' => $request->percentage,
            'expires_at' => $request->expires_at,
            'single_use' => $request->has('single_use'),
        ]);

        return redirect()->route('admin.discount-codes.index')->with('success', 'Discount code created successfully.');
    }

    public function edit(\App\Models\DiscountCode $discountCode)
    {
        return view('admin.discount_codes.edit', compact('discountCode'));
    }

    public function update(Request $request, \App\Models\DiscountCode $discountCode)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:discount_codes,code,' . $discountCode->id,
            'percentage' => 'required|integer|min:0|max:100',
            'expires_at' => 'nullable|date',
            'single_use' => 'boolean',
        ]);

        $discountCode->update([
            'code' => strtoupper($request->code),
            'percentage' => $request->percentage,
            'expires_at' => $request->expires_at,
            'single_use' => $request->has('single_use'),
        ]);

        return redirect()->route('admin.discount-codes.index')->with('success', 'Discount code updated successfully.');
    }

    public function destroy(\App\Models\DiscountCode $discountCode)
    {
        $discountCode->delete();
        return redirect()->route('admin.discount-codes.index')->with('success', 'Discount code deleted successfully.');
    }
}
