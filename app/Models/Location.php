<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['city', 'state', 'country'];

    protected $casts = [
        'city' => 'string',
        'state' => 'string',
        'country' => 'string',
    ];

    public function jobListings()
    {
        return $this->belongsToMany(JobListing::class, 'job_listing_location');
    }
};