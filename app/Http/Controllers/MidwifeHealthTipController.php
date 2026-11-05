<?php

namespace App\Http\Controllers;

use App\Models\HealthTip;
use Illuminate\Http\Request;

class MidwifeHealthTipController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->query('search', ''));
        $category = $request->query('category', '');

        $tips = HealthTip::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%");
                });
            })
            ->when($category !== '', function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->latest()
            ->get();

        return view('midwife.health-tips.index', compact('tips'));
    }

    public function create()
    {
        return view('midwife.health-tips.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('health-tips', 'public');
        }

        HealthTip::create($validated);

        return redirect()
            ->route('midwife.health-tips.index')
            ->with('success', 'Health tip created successfully.');
    }

    public function show(HealthTip $healthTip)
    {
        return view('midwife.health-tips.show', compact('healthTip'));
    }

    public function edit(HealthTip $healthTip)
    {
        return view('midwife.health-tips.edit', compact('healthTip'));
    }

    public function update(Request $request, HealthTip $healthTip)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('health-tips', 'public');
        }

        $healthTip->update($validated);

        return redirect()
            ->route('midwife.health-tips.index')
            ->with('success', 'Health tip updated successfully.');
    }

    public function destroy(HealthTip $healthTip)
    {
        if ($healthTip->image) {
            \Illuminate\Support\Facades\Storage::disk('public')
                ->delete($healthTip->image);
        }

        $healthTip->delete();

        return redirect()
            ->route('midwife.health-tips.index')
            ->with('success', 'Health tip deleted successfully.');
    }
}