<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" style="">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <x-buttons.side-link-button :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-buttons.side-link-button>

            {{-- Toggle Dropdown --}}
            <x-buttons.dropdown-side-link-button :id="__('sites')" :name="__('Sites')"
                :active="request()->routeIs('scrapper.*')">

                <x-buttons.side-link-button :id="__('sites')" :collaspe="__('true')" :href="route('scrapper.index')"
                    :show="request()->routeIs('scrapper.*')" :active="request()->routeIs('scrapper.index')">
                    {{ __('Bayt Jobs') }}
                </x-buttons.side-link-button>
            </x-buttons.dropdown-side-link-button>
        </ul>
    </div>
</nav>
