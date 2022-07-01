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
           {{ __('Company')}}

            <button type="button" class="btn btn-default border position-relative">
                Total
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $companies->total() }}
                </span>
            </button></h3>
    </div>
    <x-alert />
    <div class="card">
        <div class="card-header">
            @if($companies->total() > 0)
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
                            <th width="12%">
                                Date
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($companies as $company)
                            <tr>
                                <td>
                                    <a href="{{ optional($company)->external_url }}" target="_new" rel="noopener">
                                        {{ optional($company)->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ optional($company->created_at)->isoFormat('DD-MM-YYYY') }}
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
                    {{ $companies->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layout>
