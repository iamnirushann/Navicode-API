<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactDetail extends Model
{
    use HasFactory;

    // Specify which fields are mass assignable
    protected $fillable = [

         'type', // Type of contact detail (e.g., email, phone, address, etc.)
         'value'// Value of the contact detail (e.g., email address or phone number)
    ];
}
