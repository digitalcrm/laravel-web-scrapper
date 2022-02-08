<div>
    <x-alert />
    <form wire:submit.prevent="importSiteJob">
        @csrf
        <div class="mb-3">
            <label for="site_name" class="form-label">Import Jobs</label>
            <select wire:model="site_name" class="form-select mb-3" id="site_name">
                @foreach($sites as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
            <x-validation-error :error="__('site_name')" />
        </div>

        <div class="mb-3">
            <label for="country_job" class="form-label">Jobs for country</label>
            <select wire:model="country" class="form-select mb-3" id="country_job">
                <option value="">{{ __('Select Country') }}</option>
                @forelse($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @empty
                @endforelse
            </select>
            <x-validation-error :error="__('country')" />
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">Import CSV</label>
            <input wire:model="file" type="file" class="form-control" id="file" name="file" aria-describedby="file">
            <span><a href="{{ config('app.url') }}/csv_files/jobs.csv">download</a> csv file</span>
            <x-validation-error :error="__('file')" />
        </div>

        <button wire:loading.attr="disabled" class="btn btn-primary float-end" type="submit">
            <span wire:loading wire:target="importSiteJob" class="spinner-border spinner-border-sm" role="status"
                aria-hidden="true"></span>
            <span wire:loading.class="visually-hidden" wire:target="importSiteJob">Submit</span>
            <span wire:loading.class.remove="visually-hidden" wire:target="importSiteJob"
                class="visually-hidden">fetching...</span>
        </button>
    </form>
</div>
