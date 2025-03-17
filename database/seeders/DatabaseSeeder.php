<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\JobListing;
use App\Models\Language;
use App\Models\Location;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\JobListingAttributeValue;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Seed Languages
        $languages = ['PHP', 'JavaScript', 'Python', 'Java', 'C#', 'Ruby', 'Go', 'Swift'];
        foreach ($languages as $lang) {
            Language::create(['name' => $lang]);
        }

        // Seed Locations
        for ($i = 0; $i < 10; $i++) {
            Location::create([
                'city' => $faker->city,
                'state' => $faker->state,
                'country' => $faker->country
            ]);
        }

        // Seed Categories
        $categories = ['Software Engineering', 'Marketing', 'Design', 'Sales', 'HR', 'Finance'];
        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }

        // Seed Attributes
        $attributes = [
            ['name' => 'Years of Experience', 'type' => 'number'],
            ['name' => 'Remote Work Allowed', 'type' => 'boolean'],
            ['name' => 'Education Level', 'type' => 'select', 'options' => json_encode(['High School', 'Bachelor', 'Master'])],
        ];
        foreach ($attributes as $attr) {
            Attribute::create($attr);
        }

        // Seed Job Listings
        $jobListings = [];
        for ($i = 0; $i < 25; $i++) {
            $jobListings[] = JobListing::create([
                'title' => $faker->jobTitle,
                'description' => $faker->paragraph,
                'company_name' => $faker->company,
                'salary_min' => $faker->numberBetween(30000, 60000),
                'salary_max' => $faker->numberBetween(60000, 120000),
                'is_remote' => $faker->boolean,
                'job_type' => $faker->randomElement(['full-time', 'part-time', 'contract', 'freelance']),
                'status' => $faker->randomElement(['draft', 'published', 'archived']),
                'published_at' => $faker->dateTimeThisYear(),
            ]);
        }

        // Seed Job-Category Relationships
        foreach ($jobListings as $job) {
            $job->categories()->attach(Category::inRandomOrder()->limit(rand(1, 3))->pluck('id'));
        }

        // Seed Job-Language Relationships
        foreach ($jobListings as $job) {
            $job->languages()->attach(Language::inRandomOrder()->limit(rand(1, 3))->pluck('id'));
        }

        // Seed Job-Location Relationships
        foreach ($jobListings as $job) {
            $job->locations()->attach(Location::inRandomOrder()->limit(rand(1, 2))->pluck('id'));
        }

        // Seed Job Attributes (EAV)
        foreach ($jobListings as $job) {
            $attributes = Attribute::inRandomOrder()->limit(rand(1, 2))->get();
            foreach ($attributes as $attribute) {
                JobListingAttributeValue::create([
                    'job_listing_id' => $job->id,
                    'attribute_id' => $attribute->id,
                    'value' => $attribute->type === 'boolean' ? $faker->boolean : ($attribute->type === 'number' ? $faker->numberBetween(1, 10) : $faker->word),
                ]);
            }
        }
    }
}
