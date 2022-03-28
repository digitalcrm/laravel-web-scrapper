<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Illuminate\Support\Carbon;
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
        'search_text',
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
    const COUNTRY_SAUDI_ARABIA = 6;

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

    protected static function site_names()
    {
        $sites = [
            [
                'name' => self::SITE_BAYT,
            ],
            [
                'name' => self::SITE_JOBBANK,
            ],
            [
                'name' => self::SITE_LINKEDIN,
            ],
        ];

        return $sites;
    }

    protected function ui_avatars(string $name): string
    {
        return 'https://ui-avatars.com/api/?format=svg&background=random&name=' . $name;
    }

    /**
     * query the jobs based on date type such as weekly, today etc...
     *
     */
    protected function scopeDateType($query, $type)
    {
        switch ($type) {
            case 'weekly':
                return $query->whereBetween('job_posted', [Carbon::today()->subDays(7), Carbon::today()]);
                break;

            case 'monthly':
                return $query->whereBetween('job_posted', [Carbon::today()->subMonth(), Carbon::today()]);
                break;

            case 'today':
                return $query->whereDate('job_posted', Carbon::today());
                break;

            case 'yesterday':
                return $query->whereDate('job_posted', Carbon::today()->subDays(1));
                break;
        }
    }

    /**
     * count jobs based on site_name, country_id or date
     *
     * @param string $siteName
     * @param [type] $countryId
     * @param string|null $type
     * @return void
     */
    public function count_jobs_for_each_site_country(string $siteName, $countryId = null, string $type = null)
    {
        if ($countryId) {
            $data = Scrap::query()
                ->where('site_name', $siteName)
                ->where('country_id', $countryId)
                ->dateType($type)
                ->count();
        } else {
            $data = Scrap::query()
                ->where('site_name', $siteName)
                ->dateType($type)
                ->count();
        }

        return $data;
    }

    /**
     * get the list of site with some job data
     *
     * @param string|null $date_type
     * @return array
     */
    static protected function get_list_of_site(string $date_type = null): array
    {
        $data = [
            [
                "img" => '/logo/uae.png',
                "name" => "Bayt",
                "site_name" => "bayt",
                "country_name" => "uae",
                "attribute_name" => "bayt-jobs",
                "total_jobs"    => (new self)->count_jobs_for_each_site_country("bayt", null, $date_type),
            ],
            // [
            //     "img" => '/logo/usa.png',
            //     "name" => "Bayt USA",
            //     "site_name" => "bayt",
            //     "country_name" => "usa",
            //     "attribute_name" => "bayt-usa",
            //     "total_jobs"    => (new self)->count_jobs_for_each_site_country("bayt", self::COUNTRY_USA, $date_type),
            // ],
            [
                "img" => '/logo/saudi-arabia.png',
                "name" => "Bayt Saudi Arabia",
                "site_name" => "bayt",
                "country_name" => "sa",
                "attribute_name" => "bayt-sa",
                "total_jobs"    => (new self)->count_jobs_for_each_site_country("bayt", self::COUNTRY_SAUDI_ARABIA, $date_type),
            ],
            [
                "img" => '/logo/jobbank-canada.jpg',
                "name" => "Jobbank",
                "site_name" => "jobbank",
                "country_name" => "canada",
                "attribute_name" => "jobbank-jobs",
                "total_jobs"    => (new self)->count_jobs_for_each_site_country("jobbank", self::COUNTRY_CANADA, $date_type),
            ],
            [
                "img" => '/logo/linkedin-india.jpg',
                "name" => "Linkedin India",
                "site_name" => "linkedin",
                "country_name" => "ind",
                "attribute_name" => "linkedin-ind-jobs",
                "total_jobs"    => (new self)->count_jobs_for_each_site_country("linkedin", self::COUNTRY_IND, $date_type),
            ],
            [
                "img" => '/logo/linkedin-uae.jpg',
                "name" => "Linkedin UAE",
                "site_name" => "linkedin",
                "country_name" => "uae",
                "attribute_name" => "linkedin-uae-jobs",
                "total_jobs"    => (new self)->count_jobs_for_each_site_country("linkedin", self::COUNTRY_UAE, $date_type),
            ],
            [
                "img" => '/logo/linkedin-usa.jpg',
                "name" => "Linkedin USA",
                "site_name" => "linkedin",
                "country_name" => "usa",
                "attribute_name" => "linkedin-usa-jobs",
                "total_jobs"    => (new self)->count_jobs_for_each_site_country("linkedin", self::COUNTRY_USA, $date_type),
            ],
            [
                "img" => '/logo/linkedin-uk.jpg',
                "name" => "Linkedin UK",
                "site_name" => "linkedin",
                "country_name" => "uk",
                "attribute_name" => "linkedin-uk-jobs",
                "total_jobs"    => (new self)->count_jobs_for_each_site_country("linkedin", self::COUNTRY_UK, $date_type),
            ],
            [
                "img" => '/logo/linkedin-canada.jpg',
                "name" => "Linkedin Canada",
                "site_name" => "linkedin",
                "country_name" => "canada",
                "attribute_name" => "linkedin-canada-jobs",
                "total_jobs"    => (new self)->count_jobs_for_each_site_country("linkedin", self::COUNTRY_CANADA, $date_type),
            ],
            [
                "img" => '/logo/linkedin-sa.jpg',
                "name" => "Linkedin Saudi Arabia",
                "site_name" => "linkedin",
                "country_name" => "sa",
                "attribute_name" => "linkedin-sa-jobs",
                "total_jobs"    => (new self)->count_jobs_for_each_site_country("linkedin", self::COUNTRY_SAUDI_ARABIA, $date_type),
            ],
        ];

        return $data;
    }

    public static function distinct_search_text_category()
    {
        $tags = self::query()
                    ->select('search_text')
                    ->whereNotNull('search_text')
                    ->distinct('search_text')
                    ->take(10)
                    ->get();

        return $retVal = ($tags) ? $tags : null;
    }
}
