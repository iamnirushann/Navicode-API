<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Job;

class JobController extends Controller
{
    /**
     * Display a listing of all jobs with specific fields and include category name.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Retrieve all jobs with selected fields and load related category name
        $jobs = Job::with('category:id,name') // Load only 'id' and 'name' fields from the related category
            ->select('id', 'title', 'description', 'requirements', 'location', 'employment_type', 'category_id')
            ->get();

        // Check if any jobs exist in the database
        if ($jobs->isEmpty()) {
            return response()->json(['message' => 'No jobs available at the  in the moment'], 404);
        }

        // Transform the data to include category name directly in the job object
        $jobs = $jobs->map(function ($job) {
            return [
                'id' => $job->id,
                'title' => $job->title,
                'description' => $job->description,
                'requirements' => $job->requirements,
                'location' => $job->location,
                'employment_type' => $job->employment_type,
                'category_name' => $job->category ? $job->category->name : null,
            ];
        });

        // Return the list of jobs as JSON
        return response()->json($jobs);
    }

    /**
     * Display jobs by category ID with specific fields.
     *
     * @param  int  $category_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function view($category_id)
    {
        // Retrieve jobs filtered by category_id and select specific fields
        $jobs = Job::where('category_id', $category_id)
            ->select('id', 'title', 'requirements', 'location', 'employment_type')
            ->get();

        // Check if any jobs were found in the specified category
        if ($jobs->isEmpty()) {
            return response()->json(['message' => 'No jobs found for this category'], 404);
        }

        // Return the filtered list of jobs as JSON
        return response()->json($jobs);
    }

    /**
     * Display a specific job by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Retrieve job by ID and select specific fields
        $jobs = Job::where('id', $id)
            ->select('id', 'title', 'description', 'requirements', 'location', 'employment_type')
            ->get();

        // Check if a job was found for the specified ID
        if ($jobs->isEmpty()) {
            return response()->json(['message' => 'No jobs found for this job ID'], 404);
        }

        // Return the job data as JSON
        return response()->json($jobs);
    }

    /**
     * Store a new job record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate request data for creating a job
            $validated = $request->validate([
                'title' => 'required|string|unique:job',
                'requirements' => 'required|string',
                'location' => 'required|string',
                'category_id' => 'required|string',
                'employment_type' => 'required|string',
            ]);
            // Create a new job using the request data
            $job = Job::create($request->all());

            // Return success message with the newly created job ID
            return response()->json(['message' => 'Job details added successfully', 'job_id' => $job->id], 200);
        } catch (Exception $e) {
            // Return error message if job creation fails
            return response()->json(['message' => 'Failed to add job details, please try again.'], 404);
        }
    }

    /**
     * Update an existing job by ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Find the job by ID or return 404 if not found
        $job = Job::find($id);

        if (!$job) {
            return response()->json(['message' => 'No job detail found for this ID'], 404);
        }

        try {
            // Validate the request data for updating a job
            $validated = $request->validate([
                'title' => 'string',
                'requirements' => 'string',
                'location' => 'string',
                'category_id' => 'string',
                'employment_type' => 'string',
            ]);

            // Update job record with the validated data
            $job->update($validated);

            // Return success message for update
            return response()->json(['message' => 'Job details updated successfully'], 200);
        } catch (Exception $e) {
            // Return error message if update fails
            return response()->json(['message' => 'Failed to update job details, please try again.'], 500);
        }
    }

    /**
     * Delete a job record by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Find the job by ID or return 404 if not found
        $job = Job::find($id);

        if (!$job) {
            return response()->json(['message' => 'No job detail found for this ID'], 404);
        }

        // Delete the found job record
        $job->delete();

        // Return success message for deletion
        return response()->json(['message' => 'Job details deleted successfully'], 200);
    }
}
