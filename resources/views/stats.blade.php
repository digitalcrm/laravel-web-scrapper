<x-layout>
    <div class="row g-5 g-xl-10 mb-xl-10">
        <h3>
            {{ __('Stats') }}
        </h3>
        <div class="col-md-12 mb-md-5">
            <div class="card">
                <div class="card-body p-0 table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Device Name') }}</th>
                                <th>{{ __('IP') }}</th>
                                <th>{{ __('Country') }}</th>
                                <th>{{ __('City') }}</th>
                                <th>{{ __('IS BOT') }}</th>
                                <th>{{ __('User') }}</th>
                                <th>{{ __('Logged In') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($devices as $device)
                                <tr>
                                    <td>{{ optional($device)->device_type }}</td>

                                    <td>{{ optional($device)->ip }}</td>

                                    <td>{{ \Stevebauman\Location\Facades\Location::get("122.177.109.125")->countryName ?? ''}}</td>

                                    <td>{{ \Stevebauman\Location\Facades\Location::get("122.177.109.125")->cityName ?? '' }}</td>
                                    
                                    <td>
                                        {{ $device['data']['is_bot'] ? 'true' : 'false' }}
                                    </td>

                                    <td>
                                        @forelse($device->pivot as $pivot)
                                            <span class="badge bg-danger">
                                                {{ $pivot->user->name }}
                                            </span>
                                        @empty
                                        @endforelse
                                    </td>

                                    <th>
                                        {{ optional($device->created_at)->diffForHumans() }}
                                    </th>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">{{ __('No Data Found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $devices->links() }}
                </div>
            </div>
        </div>
    </div>

</x-layout>
