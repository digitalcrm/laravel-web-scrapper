<x-layout>
    <div class="col-12">
        <h3>
            {{ __('Search List') }}
        </h3>
    </div>
    <x-alert />
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-info position-relative">
                Total
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $jobs->total() }}
                </span>
            </button>
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
                        @forelse($jobs as $scrap)
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
                    {{ $jobs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layout>
