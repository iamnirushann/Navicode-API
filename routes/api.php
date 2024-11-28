<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ContactDetailController;
use App\Http\Controllers\SubscriberController;

// Job routes
Route::get('/jobs', [JobController::class, 'index']);          // Retrieve all job records
Route::get('/jobs/{id}', [JobController::class, 'show']);      // Retrieve a specific job by ID
Route::get('/jobs-category/{category_id}', [JobController::class, 'view']);      // Retrieve a specific job by Category ID
Route::post('/jobs', [JobController::class, 'store']);         // Create a new job
Route::put('/jobs/{id}', [JobController::class, 'update']);    // Update a specific job by ID
Route::delete('/jobs/{id}', [JobController::class, 'destroy']); // Delete a specific job by ID

// Contact Detail routes
Route::get('/contact-details', [ContactDetailController::class, 'index']);         // Retrieve all contact details
Route::get('/contact-details/{id}', [ContactDetailController::class, 'show']);      // Retrieve a specific contact detail by ID
Route::post('/contact-details', [ContactDetailController::class, 'store']);         // Create a new contact detail
Route::put('/contact-details/{id}', [ContactDetailController::class, 'update']);    // Update a specific contact detail by ID
Route::delete('/contact-details/{id}', [ContactDetailController::class, 'destroy']); // Delete a specific contact detail by ID

// Category Detail routes
Route::get('/category-details', [CategoryController::class, 'index']);         // Retrieve all contact details
Route::get('/category-details/{id}', [CategoryController::class, 'show']);      // Retrieve a specific contact detail by ID
Route::post('/category-details', [CategoryController::class, 'store']);         // Create a new contact detail
Route::put('/category-details/{id}', [CategoryController::class, 'update']);    // Update a specific contact detail by ID
Route::delete('/category-details/{id}', [CategoryController::class, 'destroy']); // Delete a specific contact detail by ID

// Subscriber Details routes
Route::get('/subscribers', [SubscriberController::class, 'index']); // Get all subscribers
Route::post('/subscribers', [SubscriberController::class, 'store']); // Add a new subscriber
Route::get('/subscribers/{id}', [SubscriberController::class, 'show']); // Get subscriber by ID
Route::delete('/subscribers/{id}', [SubscriberController::class, 'destroy']); // Delete a subscriber