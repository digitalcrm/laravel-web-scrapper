<div>
    <x-alert />
    <div class="row">
        @if($isRequest)
            <div class="col-6">
                <div class="card">
                    <form wire:submit.prevent="search_job_by_keyword">
                        <div class="card-body">
                            <div class="col mb-3">
                                <label for="search_text" class="col-form-label fw-bold">Search Keyword</label>
                                <input wire:model="filter.search_text" type="search" class="form-control"
                                    id="search_text" name="search_text">
                                <x-validation-error error="filter.search_text" />
                            </div>
                            <button type="submit" wire:target="search_job_by_keyword" wire:loading.attr="disabled"
                                class="btn btn-primary m-2 px-4 float-end">
                                {{ __('Search') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="col-md-6">
                <div class="card">
                    <form wire:submit.prevent="applyFilter">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="country_id" class="form-label fw-bold">Job Country Name</label>
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
                                <label for="site_name" class="form-label fw-bold">Sites</label>
                                <select wire:model="filter.site_name" class="form-select mb-3" id="site_name">
                                    <option value="">Select Sites</option>
                                    @forelse($sites as $site)
                                        <option value="{{ $site['name'] }}">
                                            {{ $site['name'] }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <x-validation-error error="filter.site_name" />
                            </div>
                            <div class="mb-3">
                                <label for="job_title" class="col-form-label fw-bold">Job Title</label>
                                <input wire:model="filter.job_title" type="text" class="form-control" id="job_title"
                                    name="job_title">
                                <x-validation-error error="filter.job_title" />
                            </div>

                            <div class="mb-3">
                                <label for="job_function" class="form-label fw-bold">Job Function</label>
                                {{-- <input wire:model="filter.job_function" type="text" class="form-control" id="job_function"
                                name="job_function"> --}}
                                <select wire:model="filter.job_function" name="job_function" id="job_function"
                                    class="form-select mb-3">
                                    <option value="">Select Job Function</option>
                                    @forelse($job_function as $function)
                                        <option value="{{ optional($function)->name }}">
                                            {{ optional($function)->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <x-validation-error error="filter.job_function" />
                            </div>
                            <div class="mb-3">
                                <label for="industries" class="col-form-label fw-bold">Job Industry</label>
                                {{-- <input wire:model="filter.industries" type="text" class="form-control" id="industries"
                                name="industries"> --}}
                                <select wire:model="filter.industries" name="industries" id="industries"
                                    class="form-select mb-3">
                                    <option value="">Select Job Industry</option>
                                    @forelse($job_industry as $industry)
                                        <option value="{{ optional($industry)->name }}">
                                            {{ optional($industry)->name }}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <x-validation-error error="filter.industries" />
                            </div>
                            <div class="mb-3">
                                <label for="job_state" class="col-form-label fw-bold">City</label>
                                <input wire:model="filter.job_state" type="text" class="form-control" id="job_state"
                                    name="job_state">
                                <x-validation-error error="filter.job_state" />
                            </div>
                            <div class="mb-3">
                                <label for="job_type" class="col-form-label fw-bold">Job Type</label>
                                <input wire:model="filter.job_type" type="text" class="form-control" id="job_type"
                                    name="job_type">
                                <x-validation-error error="filter.job_type" />
                            </div>
                            <div class="mb-3">
                                <label for="job_company" class="col-form-label fw-bold">Company Name</label>
                                <input wire:model="filter.job_company" type="text" class="form-control" id="job_company"
                                    name="job_company">
                                <x-validation-error error="filter.job_company" />
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="d-grid">
                                <button type="submit" wire:target="applyFilter" wire:loading.attr="disabled"
                                    {{ $filter ? '' : 'disabled' }}
                                    class="btn btn-primary m-2 px-4">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endif

    </div>
</div>
