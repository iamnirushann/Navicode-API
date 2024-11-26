<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of all categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Retrieve all categories and select only 'id' and 'name' fields
        $category = Category::select('id', 'name')->get();

        // Check if any categories exist in the database
        if ($category->isEmpty()) {
            return response()->json(['message' => 'No Category found available at the moment'], 404);
        } else {
            // Return the list of categories as JSON
            return response()->json($category);
        }
    }

    /**
     * Store a newly created category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data for creating a new category
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Create a new category using the validated data
            $category = Category::create($validated);

            // Return success message and the newly created category ID
            return response()->json(['message' => 'Category details added successfully', 'category_id' => $category->id], 200);
        } catch (Exception $e) {
            // Return error message if category creation fails
            return response()->json(['message' => 'Failed to add Category details, please try again.'], 404);
        }
    }

    /**
     * Display the specified category by ID.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        // Retrieve the category by ID and select only 'id' and 'name' fields
        $category = Category::where('id', $id)->select('id', 'name')->get();

        // Check if the category was found
        if ($category->isEmpty()) {
            return response()->json(['message' => 'No Category details found for this ID'], 404);
        } else {
            // Return the category data as JSON
            return response()->json($category);
        }
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        // Find the category by ID, return 404 if not found
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'No category detail found for this ID'], 404);
        }

        try {
            // Validate the request data for updating the category
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            // Update the category with validated data
            $category->update($validated);

            // Return success message for update
            return response()->json(['message' => 'Category detail updated successfully'], 200);
        } catch (Exception $e) {
            // Return error message if update fails
            return response()->json(['message' => 'Failed to update category details, please try again.'], 500);
        }
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        // Find the category by ID, return 404 error if not found
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'No category detail found for this ID'], 404);
        }

        // Delete the found category
        $category->delete();

        // Return success message for deletion
        return response()->json(['message' => 'Category detail deleted successfully'], 200);
    }
}
