<x-layout>
    <x-auth-validation-errors />
    <div class="card">
        <div class="card-header">
            <a role="button" class="btn btn-link float-end"
                href="{{ route('scrapper.index') }}">{{ __('Back') }}</a>
        </div>
        <div class="card-body">
            @if(request('site') == 'jobbank')
                <livewire:scrap.fetch-jobbank-data />
            @else
                <livewire:scrap.fetch-data />
            @endif
        </div>
    </div>
</x-layout>
