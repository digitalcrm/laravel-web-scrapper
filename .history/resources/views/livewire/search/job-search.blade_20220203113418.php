<div>
    <x-alert />
    <div class="card">
        <form wire:submit.prevent="applyFilter">
            <div class="card-body">

                <div class="mb-3">
                    <label for="country_id" class="form-label">Select Country Jobsdd</label>
                    <select wire:model="filter.country_id" class="form-select mb-3" id="country_id">
                        <option value="">Select Country</option>
                        @forelse($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @empty
                        @endforelse
                    </select>
                    <x-validation-error error="filter.country_id" />
                </div>

                <div class="mb-3">
                    <label for="job_title" class="col-form-label">Title:</label>
                    <input wire:model="filter.job_title" type="text" class="form-control" id="job_title"
                        name="job_title">
                    <x-validation-error error="filter.job_title" />
                </div>
                <div class="mb-3">
                    <label for="job_state" class="col-form-label">City:</label>
                    <input wire:model="filter.job_state" type="text" class="form-control" id="job_state"
                        name="job_state">
                    <x-validation-error error="filter.job_state" />
                </div>
                <div class="mb-3">
                    <label for="job_type" class="col-form-label">Type:</label>
                    <input wire:model="filter.job_type" type="text" class="form-control" id="job_type" name="job_type">
                    <x-validation-error error="filter.job_type" />
                </div>
                <div class="mb-3">
                    <label for="job_company" class="col-form-label">Company:</label>
                    <input wire:model="filter.job_company" type="text" class="form-control" id="job_company"
                        name="job_company">
                    <x-validation-error error="filter.job_company" />
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" wire:loading.attr="disabled"
                    {{ $filter ? '' : 'disabled' }}
                    class="btn btn-primary float-end m-2">
                    {{ __('Apply') }}
                </button>
            </div>
        </form>
    </div>
</div>
