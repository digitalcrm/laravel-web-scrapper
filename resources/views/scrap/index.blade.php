<x-layout>
    <div class="col-12">
        @if(request('site') == App\Models\Scrap::SITE_LINKEDIN)
            <h3>{{ App\Models\Scrap::SITE_LINKEDIN }}</h3>
        @elseif(request('site') == App\Models\Scrap::SITE_JOBBANK)
            <h3>{{ App\Models\Scrap::SITE_JOBBANK }}</h3>
        @else
            <h3>{{ App\Models\Scrap::SITE_BAYT }}</h3>
        @endif
    </div>
    <x-alert />
    <livewire:scrap.list-jobs />
</x-layout>
