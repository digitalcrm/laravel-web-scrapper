    <x-layout>
        <div class="col-12">
            <h3>
                {{ __('Search Jobs') }}
            </h3>
        </div>
        
        <x-auth-validation-errors />

        <livewire:search.job-search />
    </x-layout>
