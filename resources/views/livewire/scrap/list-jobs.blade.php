<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>No.</th>
                <th>
                    Job Title
                </th>
                <th>
                    Company
                </th>
                <th>
                    Job Type
                </th>
                <th>
                    City
                </th>
                <th>
                    Description
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
                        {{ optional($scrap)->job_title }}
                    </td>
                    <td>
                        {{ optional($scrap)->job_company }}
                    </td>
                    <td>
                        {{ $scrap->job_type }}
                    </td>
                    <td>
                        {{ optional($scrap)->job_state }}
                    </td>
                    <td>
                        {{ optional($scrap)->job_short_description }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="6">
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
