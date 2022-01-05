<x-layout>
    <x-auth-validation-errors />
    <div class="card">
        <div class="card-header">
            <a role="button" class="btn btn-link float-end" href="{{ route('scrapper.index') }}">{{ __('Back') }}</a>
        </div>
        <div class="card-body">
            <livewire:scrap.fetch-data />
        </div>
    </div>
</x-layout>
