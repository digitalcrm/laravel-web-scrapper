<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $companies = QueryBuilder::for(Company::class)
            ->allowedFilters([
                'name',
                'description',
            ])
            ->latest('created_at')
            ->paginate(Company::PAGINATE_VALUE)
            ->appends(request()->query());

        $filterQuery = request()->query('filter');

        return view('company.index', compact('companies'));
    }
}
