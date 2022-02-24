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
        'employment_type',
        'seniority_level',
        'job_function',
        'industries', // job category
    ];

    protected $casts = [
        'job_posted' => 'datetime',
    ];

    const PAGINATE_VALUE = 20;
    const SITE_LINKEDIN = 'linkedin';
    const SITE_BAYT = 'bayt';
    const SITE_JOBBANK = 'jobbank';

    const COUNTRY_UAE = 1;
    const COUNTRY_IND = 2;
    const COUNTRY_CANADA = 3;
    const COUNTRY_USA = 4;
    const COUNTRY_UK = 5;

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

    static protected function get_list_of_site(): array
    {
        $data = [
            [
                "img" => '/logo/uae.png',
                "name" => "Bayt UAE",
                "site_name" => "bayt",
                "country_name" => "uae",
                "attribute_name" => "bayt-jobs",
                "total_jobs"    => (new self)->count_jobs_for_each_site_country("bayt", self::COUNTRY_UAE),
            ],
            [
                "img" => '/logo/usa.png',
                "name" => "Bayt USA",
                "site_name" => "bayt",
                "country_name" => "usa",
                "attribute_name" => "bayt-usa",
                "total_jobs"    => (new self)->count_jobs_for_each_site_country("bayt", self::COUNTRY_USA),
            ],
            [
                "img" => '/logo/jobbank-canada.jpg',
                "name" => "Jobbank",
                "site_name" => "jobbank",
                "country_name" => "canada",
                "attribute_name" => "jobbank-jobs",
                "total_jobs"    => (new self)->count_jobs_for_each_site_country("jobbank", self::COUNTRY_CANADA),
            ],
            [
                "img" => '/logo/linkedin-india.jpg',
                "name" => "Linkedin India",
                "site_name" => "linkedin",
                "country_name" => "ind",
                "attribute_name" => "linkedin-ind-jobs",
                "total_jobs"    => (new self)->count_jobs_for_each_site_country("linkedin", self::COUNTRY_IND),
            ],
            [
                "img" => '/logo/linkedin-uae.jpg',
                "name" => "Linkedin UAE",
                "site_name" => "linkedin",
                "country_name" => "uae",
                "attribute_name" => "linkedin-uae-jobs",
                "total_jobs"    => (new self)->count_jobs_for_each_site_country("linkedin", self::COUNTRY_UAE),
            ],
            [
                "img" => '/logo/linkedin-usa.jpg',
                "name" => "Linkedin USA",
                "site_name" => "linkedin",
                "country_name" => "usa",
                "attribute_name" => "linkedin-usa-jobs",
                "total_jobs"    => (new self)->count_jobs_for_each_site_country("linkedin", self::COUNTRY_USA),
            ],
            [
                "img" => '/logo/linkedin-uk.jpg',
                "name" => "Linkedin UK",
                "site_name" => "linkedin",
                "country_name" => "uk",
                "attribute_name" => "linkedin-uk-jobs",
                "total_jobs"    => (new self)->count_jobs_for_each_site_country("linkedin", self::COUNTRY_UK),
            ],
            [
                "img" => '/logo/linkedin-canada.jpg',
                "name" => "Linkedin Canada",
                "site_name" => "linkedin",
                "country_name" => "canada",
                "attribute_name" => "linkedin-canada-jobs",
                "total_jobs"    => (new self)->count_jobs_for_each_site_country("linkedin", self::COUNTRY_CANADA),
            ],
        ];

        return $data;
    }

    public function count_jobs_for_each_site_country($siteName, $countryId)
    {
        $data = Scrap::where('site_name', $siteName)->where('country_id', $countryId)->count();

        return $data;
    }

    protected function ui_avatars(string $name): string
    {
        return 'https://ui-avatars.com/api/?format=svg&background=random&name=' . $name;
    }
}
