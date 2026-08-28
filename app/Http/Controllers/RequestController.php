<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Request as RequestModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // =========================
        // BASE QUERY
        // =========================

        $baseQuery = RequestModel::query();

        if ($user->role === 'admin') {

            // Admin melihat semua request

        } elseif ($user->role === 'staff') {

            $baseQuery->where('assigned_to', $user->id);
        } else {

            $baseQuery->where('user_id', $user->id);
        }


        // =========================
        // DASHBOARD
        // =========================

        $total = (clone $baseQuery)->count();

        $pending = (clone $baseQuery)
            ->where('status', 'pending')
            ->count();

        $inProgress = (clone $baseQuery)
            ->where('status', 'in_progress')
            ->count();

        $completed = (clone $baseQuery)
            ->where('status', 'resolved')
            ->count();

        $highPriority = (clone $baseQuery)
            ->where('priority', 'high')
            ->count();


        // =========================
        // SEARCH & FILTER QUERY
        // =========================

        $search = $request->input('search');
        $status = $request->input('status');
        $priority = $request->input('priority');
        $categoryId = $request->input('category_id');

        $query = RequestModel::with([
            'category',
            'user',
            'assignee'
        ]);

        // Role
        if ($user->role === 'admin') {
        } elseif ($user->role === 'staff') {

            $query->where('assigned_to', $user->id);
        } else {

            $query->where('user_id', $user->id);
        }


        // Search
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


        // Status
        $query->when($status, function ($query, $status) {
            $query->where('status', $status);
        });

        // Priority
        $query->when($priority, function ($query, $priority) {
            $query->where('priority', $priority);
        });


        // Category
        $query->when($categoryId, function ($query, $categoryId) {
            $query->where('category_id', $categoryId);
        });


        $requests = $query->get();

        $categories = Category::where('is_active', 'active')->get();


        return view('request.index', compact(
            'requests',
            'categories',
            'search',
            'status',
            'priority',
            'categoryId',
            'total',
            'pending',
            'inProgress',
            'completed',
            'highPriority'
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
            'category_id' => 'required|exists:categories,id',
            'assigned_to' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,critical',
        ]);
        // dd($validated);
        try {

            RequestModel::create([
                'category_id' => $validated['category_id'],
                'user_id' => Auth::id(),
                'assigned_to' => $validated['assigned_to'] ?? null,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'status' => 'pending',
                'priority' => $validated['priority'],
                'slug' => Str::slug($validated['title']) . '-' . uniqid(),
            ]);
        } catch (QueryException $e) {

            return back()
                ->withInput()
                ->with('error', 'Request gagal disimpan. Silakan coba lagi.');
        }

        return redirect()
            ->route('IndexRequest')
            ->with('success', 'Request berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $requestData = RequestModel::where('slug', $slug)->firstOrFail();
        return view('request.index', compact('requestData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $requestData = RequestModel::where('slug', $slug)->firstOrFail();

        $user = Auth::user();

        abort_unless(
            $user->role === 'admin' ||
                ($user->role === 'requester' && $requestData->user_id === $user->id),
            403
        );

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

        try {

            $requestData->update([
                'category_id' => $validated['category_id'],
                'user_id' => $validated['user_id'],
                'assigned_to' => $validated['assigned_to'] ?? null,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'priority' => $validated['priority'],
            ]);
        } catch (QueryException $e) {

            return back()
                ->withInput()
                ->with('error', 'Data request gagal diperbarui. Silakan coba lagi.');
        }

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

        try {

            $requestData->update([
                'status' => $validated['status'],
            ]);
        } catch (QueryException $e) {

            return back()
                ->with('error', 'Status gagal diperbarui. Silakan coba lagi.');
        }

        return back()
            ->with('success', 'Status berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $requestData = RequestModel::where('slug', $slug)->firstOrFail();

        try {

            $requestData->delete();
        } catch (QueryException $e) {

            return back()
                ->with('error', 'Request gagal dihapus. Silakan coba lagi.');
        }

        return redirect()
            ->route('IndexRequest')
            ->with('success', 'Request berhasil dihapus.');
    }
}
