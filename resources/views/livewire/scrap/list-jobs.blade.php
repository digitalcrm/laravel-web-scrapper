<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-info position-relative">
            Total Jobs
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $scrapper->total() }}
            </span>
        </button>

        {{-- <a href="{{ route('scrapper.create',['site'=>$this->queryType]) }}"
            type="button" class="btn btn-primary float-end ms-2">Import Jobs</a> --}}

        @if($scrapper->total() > 0)
            <button wire:click="exportJobs" class="btn btn-outline-secondary float-end">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-download" viewBox="0 0 16 16">
                    <path
                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                    <path
                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                </svg>
                Export
            </button>

            <button wire:click="exportJobs('ejobsite')" class="btn btn-outline-secondary me-2 float-end">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-download" viewBox="0 0 16 16">
                    <path
                        d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                    <path
                        d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                </svg>
                {{ __('Ejobsite Export') }}
            </button>
        @endif

        {{-- <button type="button" class="btn btn-primary float-end me-2" data-bs-toggle="modal"
            data-bs-target="#filterModal" data-bs-whatever="@mdo">Filter</button> --}}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>
                            Job Title
                        </th>
                        <th>
                            Job Country
                        </th>
                        <th>
                            State
                        </th>
                        <th>
                            Short Description
                        </th>
                        <th>
                            Description
                        </th>
                        <th>
                            Job Type
                        </th>
                        <th>
                            Company
                        </th>
                        <th>
                            Job Posted
                        </th>
                        <th class="visually-hidden">
                            Site Name
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($scrapper as $scrap)
                        <tr>
                            <td>
                                {{ $loop->index + 1 }}
                            </td>
                            <td>
                                <a href="{{ optional($scrap)->job_site_url }}" target="_new" rel="noopener">
                                    {{ optional($scrap)->job_title }}
                                </a>
                            </td>
                            <td>
                                {{ optional($scrap->country)->name }}
                            </td>
                            <td>
                                {{ optional($scrap)->job_state }}
                            </td>
                            <td>
                                {{ optional($scrap)->jobShortDescription() }}
                            </td>
                            <td>
                                {{ optional($scrap)->jobDescription() }}
                            </td>
                            <td>
                                {{ optional($scrap)->job_type }}
                            </td>
                            <td>
                                {{ optional($scrap)->job_company }}
                            </td>
                            <td>
                                {{ optional($scrap->job_posted)->isoFormat('DD-MM-YYYY') }}
                            </td>
                            <td class="visually-hidden">
                                {{ optional($scrap)->site_name }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="10">
                                No Data Found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div>
                {{ $scrapper->links() }}
            </div>
        </div>
    </div>

    {{-- Modal --}}
    {{-- <div wire:ignore.self class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">{{ __('Filter') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="submitFilter">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="job_title" class="col-form-label">Title:</label>
                            <input wire:model="filter.job_title" type="text" class="form-control" id="job_title"
                                name="job_title">
                            @error('filter.job_title') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="job_state" class="col-form-label">City:</label>
                            <input wire:model="filter.job_state" type="text" class="form-control" id="job_state"
                                name="job_state">
                            @error('filter.job_state') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">{{ __('Apply') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div> --}}
    {{-- Modal End --}}
</div>
