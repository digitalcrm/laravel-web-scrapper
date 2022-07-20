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
           {{ __('People')}}

            <button type="button" class="btn btn-default border position-relative">
                Total
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $peoples->total() }}
                </span>
            </button></h3>
    </div>
    <x-alert />
    <div class="card">
        <div class="card-header">
            @if($peoples->total() > 0)
                <x-buttons.export-btn />
            @endif
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th width="40%">
                                Name
                            </th>
                            <th width="40%">
                                subtitle
                            </th>
                            <th width="40%">
                                country
                            </th>
                            <th width="12%">
                                Date
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peoples as $people)
                            <tr>
                                <td>
                                    <a href="{{ optional($people)->external_url }}" target="_new" rel="noopener">
                                        {{ optional($people)->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ optional($people)->subtitle }}
                                </td>
                                <td>
                                    {{ optional($people)->country }}
                                </td>
                                <td>
                                    {{ optional($people->created_at)->isoFormat('DD-MM-YYYY') }}
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
                    {{ $peoples->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layout>
