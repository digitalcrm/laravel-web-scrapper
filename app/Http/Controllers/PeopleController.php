<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class PeopleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $peoples = QueryBuilder::for(People::class)
            ->allowedFilters([
                'name',
                'subtitle',
                'country',
            ])
            ->latest('created_at')
            ->paginate(People::PAGINATE_VALUE)
            ->appends(request()->query());

        $filterQuery = request()->query('filter');

        return view('people.index', compact('peoples'));
    }
}
