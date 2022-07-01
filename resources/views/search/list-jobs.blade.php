<x-layout>
    <style>
        tr {
            vertical-align: middle;
        }

        a {
            text-decoration: none;
            color: #2557a7;
        }

    </style>

    <div class="col-12">
        <h3>
            {{ $heading ? $heading : 'Search Result' }}

            <button type="button" class="btn btn-default border position-relative">
                Total
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $jobs->total() }}
                </span>
            </button></h3>
    </div>
    <x-alert />
    <div class="card">
        <div class="card-header">
            @if($jobs->total() > 0)
                <x-buttons.export-btn />
            @endif
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th class="text-center" width="10%">Sr. No.</th>
                            <th width="40%">
                                Job Title
                            </th>
                            <th>
                                Country
                            </th>
                            <th width="20%">
                                State
                            </th>
                            <th>
                                Short Description
                            </th>
                            <th>
                                Description
                            </th>
                            <th width="10%">
                                Job Type
                            </th>
                            <th>
                                Job Function
                            </th>
                            <th>
                                Industries
                            </th>
                            <th>
                                Company
                            </th>
                            <th width="12%">
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
                                <td class="text-center">
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
                                    {{ optional($scrap)->job_function }}
                                </td>
                                <td>
                                    {{ optional($scrap)->industries }}
                                </td>
                                <td>
                                    <a href="{{ optional($scrap)->company_link }}" target="_new" rel="noopener">
                                        {{ optional($scrap)->job_company }}
                                    </a>
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
                                <td class="text-center" colspan="15">
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
