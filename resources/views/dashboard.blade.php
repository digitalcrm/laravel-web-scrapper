@php

    $data = [
    ["img" => "/logo/usa.png", "name" => "USA"],
    ["img" => "/logo/canada.png", "name" => "Canada"],
    ["img" => "/logo/uae.png", "name" => "UAE"],
    ["img" => "/logo/uk.png", "name" => "UK"],
    ["img" => "/logo/india.png", "name" => "India"],
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
                            href="{{ route('search.list', ['filter[country.name]' => $val['name']]) }}">
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
