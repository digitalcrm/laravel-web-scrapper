@php

    $data = [
    ["img" => "/logo/usa.png", "name" => "USA", "sortname" => "usa"],
    ["img" => "/logo/canada.png", "name" => "Canada", "sortname" => "canada"],
    ["img" => "/logo/uae.png", "name" => "UAE", "sortname" => "uae"],
    ["img" => "/logo/uk.png", "name" => "UK", "sortname" => "uk"],
    ["img" => "/logo/india.png", "name" => "India", "sortname" => "ind"],
    ["img" => "/logo/saudi-arabia.png", "name" => "Saudi Arabia", "sortname" => "sa"],
    ["img" => "/logo/liberia.webp", "name" => "Liberia", "sortname" => "liberia"],
    ];
@endphp
<x-layout>
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
                        <a
                            href="{{ route('search.list', ['filter[country.sortname]' => $val['name']]) }}">
                            <div class="card service-card card-inverse py-4">
                                <div class="card-block">
                                    <img class="flag" src="{{ config('app.url').$val['img'] }}"
                                        alt="{{ $val['name'] }}">
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
