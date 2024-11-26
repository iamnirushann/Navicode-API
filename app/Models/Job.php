<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'jobs';

    // Specify the primary key field for the model
    protected $primaryKey = 'id';

    // Specify which fields are mass assignable
    protected $fillable = [
        'title', // Job title (e.g., Software Engineer)
        'description', // Job description detailing responsibilities
        'requirements', // Job requirements detailing requirements
        'location', // Job location (e.g., Remote, On-site, etc.)
        'category_id', //  Category id
        'employment_type' // Type of job (e.g., Full-time, Part-time, Internship)
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
