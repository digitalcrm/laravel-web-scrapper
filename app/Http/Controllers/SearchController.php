<?php

namespace App\Http\Controllers;

use App\Models\Scrap;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class SearchController extends Controller
{
    public function index()
    {
        $jobs = QueryBuilder::for(Scrap::class)
        ->allowedFilters(['job_title', 'job_company', 'job_state', 'country_id', 'job_type'])
        ->latest()
        ->paginate(Scrap::PAGINATE_VALUE)
        ->appends(request()->query());

        return view('search.list-jobs', compact('jobs'));
    }

    public function searchForm()
    {
        return view('scrap.search');
    }
}
