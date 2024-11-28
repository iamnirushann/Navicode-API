<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    // Fetch all subscribers
    public function index()
    {
        $subscribers = Subscriber::all();

        if ($subscribers->isEmpty()) {
            return response()->json(['message' => 'No subscribers found.'], 200);
        }

        return response()->json(['message' => 'Subscribers retrieved successfully.', 'data' => $subscribers], 200);
    }

    // Add a new subscriber
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:subscribers,email',
        ]);

        $subscriber = Subscriber::create($validatedData);

        return response()->json([
            'message' => 'Thank you for subscribing! You will receive job alerts soon.',
            'subscriber' => $subscriber
        ], 201);
    }

    // Fetch a single subscriber by ID
    public function show($id)
    {
        $subscriber = Subscriber::find($id);

        if (!$subscriber) {
            return response()->json(['error' => 'Subscriber not found. Please check the ID and try again.'], 404);
        }

        return response()->json([
            'message' => 'Subscriber retrieved successfully.',
            'data' => $subscriber
        ], 200);
    }

    // Delete a subscriber
    public function destroy($id)
    {
        $subscriber = Subscriber::find($id);

        if (!$subscriber) {
            return response()->json(['error' => 'Subscriber not found. Please check the ID and try again.'], 404);
        }

        $subscriber->delete();

        return response()->json([
            'message' => 'Subscriber deleted successfully. Thank you for being with us!',
        ], 200);
    }
}
