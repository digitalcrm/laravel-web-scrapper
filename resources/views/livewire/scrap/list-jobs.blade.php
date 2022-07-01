<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-info position-relative">
            Total Jobs
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $scrapper->total() }}
            </span>
        </button>

        @env('local')
            <a href="{{ route('scrapper.create',['site'=>$this->site_name]) }}"
            type="button" class="btn btn-primary text-white float-end ms-2">Import Jobs</a>
        @endenv

        @if($scrapper->total() > 0)
            <x-buttons.export-btn />
        @endif
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>
                            Job Title
                        </th>
                        <th>
                            Site Name
                        </th>
                        <th>
                            Job Type
                        </th>
                        <th>
                            Job Function
                        </th>
                        <th>
                            Industries
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
                            Company
                        </th>
                        <th>
                            Job Posted
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
                                {{ optional($scrap)->site_name }}
                            </td>
                            <td>
                                {{ optional($scrap)->job_type }}
                            </td>
                            <td>
                                {{ optional($scrap)->job_function }}
                            </td>
                            <td>
                                {{ optional($scrap)->industries }}
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
                                <a href="{{ optional($scrap)->company_link }}" target="_new" rel="noopener">
                                    {{ optional($scrap)->job_company }}
                                </a>
                            </td>
                            <td>
                                {{ optional($scrap->job_posted)->isoFormat('DD-MM-YYYY') }}
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
</div>
