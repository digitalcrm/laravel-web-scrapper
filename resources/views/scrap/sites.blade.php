<x-layout>
    <section class="service-categories text-xs-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <h1>{{ __('Sites') }}</h1>
                </div>
            </div>
            <div class="row text-center">
                @forelse($data as $val)
                    <div class="col-md-3 mb-4">
                        <a href="{{ route('scrapper.index', [
                            'filter[site_name]' => $val['site_name'],
                            'filter[country.sortname]' => $val['country_name']
                            ]) }}">
                            <div class="card service-card card-inverse py-4">
                                <div class="card-block">
                                    <img class="flag" src="{{ config('app.url').$val['img'] }}"
                                        alt="{{ $val['site_name'] }}">
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
