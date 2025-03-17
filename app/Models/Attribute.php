<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'options'];

    protected $casts = ['options' => 'array'];

    protected $attributes = ['options' => '[]'];

    public function attributeValues()
    {
        return $this->hasMany(JobListingAttributeValue::class);
    }

    public function jobListings()
    {
        return $this->hasManyThrough(JobListing::class, JobListingAttributeValue::class, 'attribute_id', 'id', 'id', 'job_listing_id');
    }
}
