<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'company_name',
        'salary_min', 'salary_max', 'is_remote',
        'job_type', 'status', 'published_at'
    ];

    protected $casts = [
        'is_remote' => 'boolean',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
    ];

    protected $dates = ['published_at'];

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'job_listing_language');
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'job_listing_location');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_job_listing');
    }

    public function attributeValues()
    {
        return $this->hasMany(JobListingAttributeValue::class);
    }
};