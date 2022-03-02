<?php

namespace App\Http\Controllers;

use App\Models\Scrap;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class SearchController extends Controller
{
    public function index()
    {
        $heading = null;
        $jobs = QueryBuilder::for(Scrap::class)
            ->allowedFilters([
                'job_title',
                'job_company',
                'job_function',
                'industries',
                'seniority_level',
                'job_state',
                'country_id',
                'job_type',
                'site_name',
                AllowedFilter::partial('country.name')
            ])
            ->allowedIncludes(['country'])
            ->latest('job_posted')
            ->paginate(Scrap::PAGINATE_VALUE)
            ->appends(request()->query());

        $filterQuery = request()->query('filter');

        if (Arr::exists($filterQuery, 'country.name')) {
            $heading = Str::upper($filterQuery['country.name']);
        }

        return view('search.list-jobs', compact('jobs', 'heading'));
    }

    public function searchForm()
    {
        return view('scrap.search');
    }
}
