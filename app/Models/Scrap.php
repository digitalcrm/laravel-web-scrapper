<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scrap extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'job_title',
        'slug',
        'job_site_url',
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

    const PAGINATE_VALUE = 5;
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

    public function jobDescription()
    {

        $data = $this->job_description ? Str::limit($this->job_description, 50, '...') : '';

        return $data;
    }

    public function jobShortDescription()
    {

        $data = $this->job_description ? Str::limit($this->job_description, 25, '...') : '';

        return $data;
    }

    protected static function get_list_of_site(): array
    {
        $data = [
            [
                "img" => '/logo/uae.png',
                "name" => "Bayt UAE",
                "site_name" => "bayt",
                "country_name" => "uae",
                "attribute_name" => "bayt-jobs",
            ],
            [
                "img" => '/logo/usa.png',
                "name" => "Bayt USA",
                "site_name" => "bayt",
                "country_name" => "usa",
                "attribute_name" => "bayt-usa",
            ],
            [
                "img" => '/logo/jobbank-canada.jpg',
                "name" => "Jobbank" ,
                "site_name" => "jobbank",
                "country_name" => "canada",
                "attribute_name" => "jobbank-jobs",
            ],
            [
                "img" => '/logo/linkedin-india.jpg',
                "name" => "Linkedin India",
                "site_name" => "linkedin",
                "country_name" => "ind",
                "attribute_name" => "linkedin-ind-jobs",
            ],
            [
                "img" => '/logo/linkedin-uae.jpg',
                "name" => "Linkedin UAE",
                "site_name" => "linkedin",
                "country_name" => "uae",
                "attribute_name" => "linkedin-uae-jobs",
            ],
            [
                "img" => '/logo/linkedin-usa.jpg',
                "name" => "Linkedin USA",
                "site_name" => "linkedin",
                "country_name" => "usa",
                "attribute_name" => "linkedin-usa-jobs",
            ],
            [
                "img" => '/logo/linkedin-uk.jpg',
                "name" => "Linkedin UK",
                "site_name" => "linkedin",
                "country_name" => "uk",
                "attribute_name" => "linkedin-uk-jobs",
            ],
            [
                "img" => '/logo/linkedin-canada.jpg',
                "name" => "Linkedin Canada",
                "site_name" => "linkedin",
                "country_name" => "canada",
                "attribute_name" => "linkedin-canada-jobs",
            ],
        ];

        return $data;
    }

    protected function ui_avatars(string $name): string
    {
        return 'https://ui-avatars.com/api/?format=svg&background=random&name=' . $name;
    }
}
