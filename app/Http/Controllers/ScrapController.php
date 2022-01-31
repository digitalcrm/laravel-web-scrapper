<?php

namespace App\Http\Controllers;

use Goutte\Client;
use App\Models\Scrap;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ScrapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $requestName = request()->query('filter');
        if ($requestName && Arr::exists($requestName, 'site_name')) {
            $heading = Str::upper($requestName['site_name']);
        } else {
            $heading = 'All Jobs';
        }

        return view('scrap.index', compact('heading'));
    }

    public function create()
    {
        return view('scrap.create');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'site_url' => ['required', 'url'],
        ]);

        $client = new Client();

        $url = $validateData['site_url'];

        $crawler = $client->request('GET', $url);

        for ($i = 0; $i < 10; $i++) {
            if ($i != 0) {
                $crawler = $client->request('GET', $url . '/?page=' . $i);
            }
            $crawler->filter('.has-pointer-d')->each(function ($node) {

                $this->results[0] = $node->filter('h2')->text(); // title
                $this->results[1] = $node->filter('.t-small p')->text(); // description
                $this->results[2] = explode('-', $node->filter('.p10r')->text())[0]; // company
                $this->results[3] = explode('-', $node->filter('.p10r')->text())[1]; // city
                $this->results[4] = $node->filter('.t-small ul li')->text(); // job_type

                Scrap::updateOrCreate(
                    ['job_title' => $this->results[0]],
                    [
                        'job_title' => $this->results[0],
                        'job_short_description' => $this->results[1],
                        'job_description' => $this->results[1],
                        'job_company' => $this->results[2],
                        'job_state' => $this->results[3],
                        'job_type' => $this->results[4],
                    ]
                );
            });
        }

        return redirect()->route('scrapper.index')->with('message', 'data successfully scrapped');
    }

    public function show($id)
    {
        // 
    }

    public function edit(Request $request, $id)
    {
        // 
    }

    public function update($id)
    {
        // 
    }

    public function destroy($id)
    {
        // 
    }

    public function jobImport()
    {
        return view('scrap.import');
    }
}
