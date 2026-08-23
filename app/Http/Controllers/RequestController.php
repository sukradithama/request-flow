<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Request as RequestModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = RequestModel::get();
        return view('request.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $users = User::where('is_active', true)->get();
        return view('request.create', compact('categories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required',
            'user_id' => 'required',
            'assigned_to' => 'nullable',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,critical',
        ]);
        $newRequest = RequestModel::create([
            'category_id' => $validated['category_id'],
            'user_id' => $validated['user_id'],
            'assigned_to' => $validated['assigned_to'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => 'pending',
            'priority' => $validated['priority'],
            'slug' => Str::slug($validated['title']) . '-' . uniqid(),
        ]);
        return redirect()
            ->route('IndexRequest')
            ->with('success', 'Request berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $requestData = RequestModel::where('slug', $slug)->firstOrFail();
        $categories = Category::where('is_active', true)->get();
        $users = User::where('is_active', true)->get();
        return view('request.edit', compact('requestData', 'categories', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'assigned_to' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,critical',
        ]);

        $requestData = RequestModel::where('slug', $slug)->firstOrFail();

        $requestData->update([
            'category_id' => $validated['category_id'],
            'user_id' => $validated['user_id'],
            'assigned_to' => $validated['assigned_to'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
        ]);

        return redirect()
            ->route('IndexRequest')
            ->with('success', 'Request berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $requestData = RequestModel::where('slug', $slug)->firstOrFail();

        $requestData->delete();

        return redirect()
            ->route('IndexRequest')
            ->with('success', 'Request berhasil dihapus.');
    }
}
