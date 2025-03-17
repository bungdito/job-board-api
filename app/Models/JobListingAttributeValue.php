<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobListingAttributeValue extends Model
{
    use HasFactory;

    protected $table = 'job_listing_attribute_values';

    protected $fillable = ['job_listing_id', 'attribute_id', 'value'];

    protected $casts = ['value' => 'json'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function jobListing()
    {
        return $this->belongsTo(JobListing::class);
    }
};