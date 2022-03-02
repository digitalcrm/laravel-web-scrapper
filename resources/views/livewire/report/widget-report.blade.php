<div class="row g-5 g-xl-10 mb-xl-10">
    <h3>
        {{ __('JOBS') }}
        <span class="badge bg-info">{{ $filtered_jobs }}</span>
    </h3>

    <div class="col-md-12 mb-md-5">
        <div class="card">
            <div class="card-header">
                <select wire:model="date_type" name="date_filter" id="date_filter"
                    class="form-select form-select-lg mb-3">
                    <option value="all_time">All Time</option>
                    <option value="weekly">Weekly</option>
                    <option value="today">Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="monthly">Monthly</option>
                </select>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-sm table-borderless">
                    <caption>Total jobs: {{ $filtered_jobs }}</caption>
                    <thead>
                        <tr>
                            <th class="fw-normal">{{ __('Sites') }}</th>
                            <th class="fw-normal">{{ __('Total Jobs') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($total_jobs_for_each_site as $siteJob)
                            <tr>
                                <td>{{ $siteJob['name'] }}</td>
                                <td>{{ $siteJob['total_jobs'] }}</td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
