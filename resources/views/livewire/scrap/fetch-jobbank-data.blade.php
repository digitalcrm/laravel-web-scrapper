<div>
    <x-alert />
    <form wire:submit.prevent="fetch">
        @csrf
        <div class="mb-3">
            <label for="country_job" class="form-label">Country</label>
            <select wire:model="country" class="form-select mb-3" id="country_job" disabled>
                @forelse($countries as $country)
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @empty
                @endforelse
            </select>
        </div>

        <div class="mb-3 visually-hidden">
            <label for="site_url" class="form-label">Site Url</label>
            <input wire:model="site_url" type="url" class="form-control" id="site_url" name="site_url"
                aria-describedby="site_url" readonly>
        </div>

        <button wire:loading.attr="disabled" class="btn btn-primary float-end" type="submit">
            <span wire:loading wire:target="fetch" class="spinner-border spinner-border-sm" role="status"
                aria-hidden="true"></span>
            <span wire:loading.class="visually-hidden" wire:target="fetch">Submit</span>
            <span wire:loading.class.remove="visually-hidden" wire:target="fetch"
                class="visually-hidden">fetching...</span>
        </button>
    </form>

</div>
