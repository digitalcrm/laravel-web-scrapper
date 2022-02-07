<x-layout>
    <div class="col-12">
        <h3>
            @if($heading)
                {{ $heading['site_name'] }}
                <span class="badge bg-secondary">{{ $heading['country_name'] }}</span>
            @endif
        </h3>
    </div>
    <x-alert />
    <livewire:scrap.list-jobs />
</x-layout>
