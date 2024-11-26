<?php

namespace App\Http\Controllers;

use App\Models\ContactDetail;
use Exception;
use Illuminate\Http\Request;

class ContactDetailController extends Controller
{
    /**
     * Display a listing of all contact details.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Retrieve all contact details and select only 'id', 'type', and 'value' fields
        $contactDetail = ContactDetail::select('id', 'type', 'value')->get();

        // Check if any contact details exist in the database
        if ($contactDetail->isEmpty()) {
            return response()->json(['message' => 'No ContactDetail available at the moment'], 404);
        } else {
            // Return the list of contact details as JSON
            return response()->json($contactDetail);
        }
    }

    /**
     * Display the specified contact detail by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Retrieve the contact detail by ID and select only 'id', 'type', and 'value' fields
        $contactDetail = ContactDetail::where('id', $id)->select('id', 'type', 'value')->get();

        // Check if the contact detail was found
        if ($contactDetail->isEmpty()) {
            return response()->json(['message' => 'No ContactDetail found for this ID'], 404);
        } else {
            // Return the contact detail data as JSON
            return response()->json($contactDetail);
        }
    }

    /**
     * Store a new contact detail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data for creating a contact detail
            $validated = $request->validate([
                'type' => 'required|string|in:email,phone,address,facebook,twitter,linkedin,instagram',
                'value' => 'required|string|max:255',
            ]);

            // Create a new contact detail using the validated data
            $contactDetail = ContactDetail::create($validated);

            // Return success message and the newly created contact detail ID
            return response()->json(['message' => 'Contact details added successfully', 'contactDetails_id' => $contactDetail->id], 200);
        } catch (Exception $e) {
            // Return error message if contact detail creation fails
            return response()->json(['message' => 'Failed to add contact details, please try again.'], 404);
        }
    }

    /**
     * Update an existing contact detail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Find the contact detail by ID, return 404 if not found
        $contactDetail = ContactDetail::find($id);
        if (!$contactDetail) {
            return response()->json(['message' => 'No ContactDetail found for this ID'], 404);
        }

        try {
            // Validate the request data for updating the contact detail
            $validated = $request->validate([
                'type' => 'string|in:email,phone,address,facebook,twitter,linkedin,instagram',
                'value' => 'string|max:255',
            ]);

            // Update the contact detail with validated data
            $contactDetail->update($validated);

            // Return success message for update
            return response()->json(['message' => 'Contact detail updated successfully'], 200);
        } catch (Exception $e) {
            // Return error message if update fails
            return response()->json(['message' => 'Failed to update contact details, please try again.'], 500);
        }
    }

    /**
     * Remove the specified contact detail from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Find the contact detail by ID, return 404 if not found
        $contactDetail = ContactDetail::find($id);
        if (!$contactDetail) {
            return response()->json(['message' => 'No ContactDetail found for this ID'], 404);
        }

        // Delete the found contact detail
        $contactDetail->delete();

        // Return success message for deletion
        return response()->json(['message' => 'Contact detail deleted successfully'], 200);
    }
}
