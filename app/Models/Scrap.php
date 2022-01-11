<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Scrap extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'job_title',
        'slug',
        'job_reference',
        'country_id', // country
        'job_state', // or city
        'job_location',
        'job_salary',
        'job_industry', // job category
        'job_company',
        'job_short_description',
        'job_description',
        'job_type',
        'job_experience',
        'job_duration',
        'job_skills',
        'job_salary_range', // salary range
        'job_tags',
        'job_posted',
        'site_name',
    ];

    protected $casts = [
        'job_posted' => 'datetime',
    ];

    const PAGINATE_VALUE = 10;
    const SITE_LINKEDIN = 'linkedin';
    const SITE_BAYT = 'bayt';
    const SITE_JOBBANK = 'jobbank';

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
        ->generateSlugsFrom('job_title')
        ->saveSlugsTo('slug');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
