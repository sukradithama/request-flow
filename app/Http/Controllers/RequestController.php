<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Request as RequestModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $user = Auth::user();

    $search = $request->input('search');
    $status = $request->input('status');
    $priority = $request->input('priority');
    $categoryId = $request->input('category_id');

    $query = RequestModel::with([
        'category',
        'user',
        'assignee'
    ]);

    // =========================
    // ROLE FILTER
    // =========================

    if ($user->role === 'admin') {

        // Admin dapat melihat semua request

    } elseif ($user->role === 'staff') {

        // Staff hanya melihat request yang ditugaskan kepadanya
        $query->where('assigned_to', $user->id);

    } else {

        // Requester hanya melihat request miliknya
        $query->where('user_id', $user->id);
    }


    // =========================
    // SEARCH
    // =========================

    $query->when($search, function ($query, $search) {

        $query->where(function ($query) use ($search) {

            $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%")

                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })

                ->orWhereHas('assignee', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });

        });

    });


    // =========================
    // FILTER STATUS
    // =========================

    $query->when($status, function ($query, $status) {

        $query->where('status', $status);

    });


    // =========================
    // FILTER PRIORITY
    // =========================

    $query->when($priority, function ($query, $priority) {

        $query->where('priority', $priority);

    });


    // =========================
    // FILTER CATEGORY
    // =========================

    $query->when($categoryId, function ($query, $categoryId) {

        $query->where('category_id', $categoryId);

    });


    $requests = $query->get();


    // Categories untuk dropdown filter
    $categories = Category::where('is_active', true)->get();;


    return view('request.index', compact(
        'requests',
        'categories',
        'search',
        'status',
        'priority',
        'categoryId'
    ));
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
            'exist:categories,id,is_active,1',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,critical',
        ]);
        $newRequest = RequestModel::create([
            'category_id' => $validated['category_id'],
            'user_id' => Auth::id(),
            'assigned_to' => null,
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
            'assigned_to' => 'nullable|exists:users,id,role,staff',
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

    public function updateStatus(Request $request, string $slug)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,rejected',
        ]);

        $requestData = RequestModel::where('slug', $slug)->firstOrFail();

        $requestData->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Status berhasil diperbarui.');
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
