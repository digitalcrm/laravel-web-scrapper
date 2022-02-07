<div>
    <div class="row g-5 g-xl-10 mb-xl-10">
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-3 mb-md-5 mb-xl-10">
            <div class="card card-flush h-md-50 mb-5 mb-xl-10">
                <div class="card-header pt-3">
                    <div class="card-title d-flex flex-column">
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-primary position-relative" disabled>
                                {{ __('Total Jobs') }}
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $totalJobs }}
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-2 pb-4 d-flex align-items-center">
                    <div class="d-flex flex-center me-5 pt-2">
                        <div id="kt_card_widget_4_chart" style="min-width: ; min-height: 70px" data-kt-size="70"
                            data-kt-line="11"></div>
                    </div>
                    <div class="d-flex flex-column content-justify-center w-100">
                        <div class="d-flex fs-6 fw-bold align-items-center">
                            <div class="bullet w-8px h-6px rounded-2 bg-danger me-3"></div>
                            <div class="text-gray-500 flex-grow-1 me-4">Bayt Jobs</div>
                            <div class="fw-boldest text-gray-700 text-xxl-end">{{ $baytJobs }}</div>
                        </div>

                        <div class="d-flex fs-6 fw-bold align-items-center">
                            <div class="bullet w-8px h-6px rounded-2 bg-danger me-3"></div>
                            <div class="text-gray-500 flex-grow-1 me-4">LinkedIn Jobs</div>
                            <div class="fw-boldest text-gray-700 text-xxl-end">{{ $linkedinJobs }}</div>
                        </div>

                        <div class="d-flex fs-6 fw-bold align-items-center">
                            <div class="bullet w-8px h-6px rounded-2 bg-danger me-3"></div>
                            <div class="text-gray-500 flex-grow-1 me-4">JobBank Jobs</div>
                            <div class="fw-boldest text-gray-700 text-xxl-end">{{ $jobbankJobs }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
