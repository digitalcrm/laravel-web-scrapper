@php

    $data = [
    ["img" => "https://cricketu.com/images/usa.png", "name" => "usa"],
    ["img" => "https://cricketu.com/images/canada.png", "name" => "canada"],
    ["img" => "https://cricketu.com/images/uae.png", "name" => "uae"],
    ["img" => "https://cricketu.com/images/uk.png", "name" => "uk"],
    ["img" => "https://cricketu.com/images/india.png", "name" => "india"],
    ];
@endphp
<x-layout>

    <style>
        /*DEMO ONLY*/
        a {
            text-decoration: none;
        }

        .service-categories {
            padding-bottom: 3em;
            background-size: cover;
        }


        /*DEMO ONLY*/

        .service-categories .card {
            transition: all 0.3s;
        }

        .service-categories .card-title {
            padding-top: 0.5em;
        }

        .service-categories a:hover {
            text-decoration: none;
        }

        .service-card {
            background: #eee;
            border: 1px solid #ccc;
        }

        .service-card:hover {
            background: #ccc;
            box-shadow: 2px 4px 8px 0px rgba(46, 61, 73, 0.2) border: 1px solid #ccc;
        }

        .fa {
            color: white;
        }

        .flag {
            width: 100px;
            height: 100px;
            object-fit: unset;
            border-radius: 50%;
        }

    </style>

    <section class="service-categories text-xs-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <h1>Job Wrap By Countries</h1>
                </div>
            </div>
            <div class="row text-center">

                @forelse($data as $val)
                    <div class="col-md-4 mb-4">
                        <a href="{{ route('search.list', ['filter[country.name]' => $val['name']]) }}">
                            <div class="card service-card card-inverse py-4">
                                <div class="card-block">
                                    <img class="flag" src="{{ $val['img'] }}" alt="{{ $val['name'] }}">
                                    <h4 class="card-title">{{ $val['name'] }}</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty

                @endforelse
            </div>
            <!--End Row-->

        </div>
    </section>

</x-layout>
