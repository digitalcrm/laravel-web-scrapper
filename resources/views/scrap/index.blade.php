<x-layout>
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-info position-relative">
                Total Jobs
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $total }}
                </span>
            </button>
            <a href="{{ route('scrapper.create') }}" type="button"
                class="btn btn-primary float-end">Import Jobs</a>
        </div>
        <div class="card-body">
            <livewire:scrap.list-jobs />
        </div>
    </div>
</x-layout>
