<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use App\Services\JobListingFilterService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class JobListingController extends Controller
{
    protected JobListingFilterService $filterService;

    public function __construct(JobListingFilterService $filterService)
    {
        $this->filterService = $filterService;
    }

    /**
     * Display a listing of the resource with advanced filtering.
     */
    public function index(Request $request): JsonResponse
    {
        $query = JobListing::query()->with(['languages', 'locations', 'categories', 'attributeValues']);

        try {
            $filters = $request->query('filter', '');
            $jobs = $this->filterService->applyAdvancedFilters($query, $filters);
            return response()->json($jobs->paginate(10));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company_name' => 'required|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|gte:salary_min',
            'is_remote' => 'boolean',
            'job_type' => 'required|in:full-time,part-time,contract,freelance',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'languages' => 'array',
            'locations' => 'array',
            'categories' => 'array',
            'attributes' => 'array',
        ]);

        $job = JobListing::create($validatedData);

        if (!empty($validatedData['languages'])) {
            $job->languages()->attach($validatedData['languages']);
        }
        if (!empty($validatedData['locations'])) {
            $job->locations()->attach($validatedData['locations']);
        }
        if (!empty($validatedData['categories'])) {
            $job->categories()->attach($validatedData['categories']);
        }

        return response()->json($job->load(['languages', 'locations', 'categories', 'attributeValues']), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(JobListing $job): JsonResponse
    {
        return response()->json($job->load(['languages', 'locations', 'categories', 'attributeValues']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobListing $job): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'company_name' => 'sometimes|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|gte:salary_min',
            'is_remote' => 'boolean',
            'job_type' => 'sometimes|in:full-time,part-time,contract,freelance',
            'status' => 'sometimes|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'languages' => 'array',
            'locations' => 'array',
            'categories' => 'array',
            'attributes' => 'array',
        ]);

        $job->update($validatedData);

        if (!empty($validatedData['languages'])) {
            $job->languages()->sync($validatedData['languages']);
        }
        if (!empty($validatedData['locations'])) {
            $job->locations()->sync($validatedData['locations']);
        }
        if (!empty($validatedData['categories'])) {
            $job->categories()->sync($validatedData['categories']);
        }

        return response()->json($job->load(['languages', 'locations', 'categories', 'attributeValues']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobListing $job): JsonResponse
    {
        $job->delete();
        return response()->json(['message' => 'Job deleted successfully']);
    }
}
