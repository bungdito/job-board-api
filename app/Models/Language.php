<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $casts = ['name' => 'string'];

    public function jobListings()
    {
        return $this->belongsToMany(JobListing::class, 'job_listing_language');
    }
};