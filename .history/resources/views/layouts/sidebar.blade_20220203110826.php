<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" style="">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <x-buttons.side-link-button :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <x-icons.home-icon />
                {{ __('Dashboard') }}
            </x-buttons.side-link-button>

            {{-- Toggle Dropdown --}}
            <x-buttons.dropdown-side-link-button :id="__('sites')" :name="__('Websites')"
                :active="request()->routeIs('scrapper.*')">
                <x-buttons.side-link-button :id="__('sites')" :collaspe="__('true')" :href="route('scrapper.index', ['filter[site_name]' => 'bayt'])"
                    :show="request()->routeIs('scrapper.*')" :active="request()->routeIs('scrapper.index')">
                    <x-icons.page-icon /> {{ __('Bayt Jobs') }}
                </x-buttons.side-link-button>

                <x-buttons.side-link-button :id="__('sites')" :collaspe="__('true')" :href="route('scrapper.index', ['filter[site_name]' => 'jobbank'])"
                    :show="request()->routeIs('scrapper.*')" :active="request()->routeIs('scrapper.index')">
                    <x-icons.page-icon /> {{ __('JobBank Jobs') }}
                </x-buttons.side-link-button>

                <x-buttons.side-link-button :id="__('sites')" :collaspe="__('true')" :href="route('scrapper.index', ['filter[site_name]' => 'linkedin'])"
                    :show="request()->routeIs('scrapper.*')" :active="request()->routeIs('scrapper.index')">
                    <x-icons.page-icon /> {{ __('LinkedIn Jobs') }}
                </x-buttons.side-link-button>

                <x-buttons.side-link-button :id="__('sites')" :collaspe="__('true')" :href="route('scrapper.index')"
                    :show="request()->routeIs('scrapper.*')" :active="request()->routeIs('scrapper.index')">
                    <x-icons.page-icon /> {{ __('All Jobs') }}
                </x-buttons.side-link-button>

                <x-buttons.side-link-button :id="__('sites')" :collaspe="__('true')" :href="route('scrapper.import')"
                    :show="request()->routeIs('scrapper.*')" :active="request()->routeIs('scrapper.import')">
                    <x-icons.page-icon /> {{ __('Import Jobs using csv') }}
                </x-buttons.side-link-button>
            </x-buttons.dropdown-side-link-button>

            <x-buttons.side-link-button :href="route('reports')" :active="request()->routeIs('reports')">
                <x-icons.page-icon /> {{ __('Reports') }}
            </x-buttons.side-link-button>

            <x-buttons.side-link-button :href="route('search.form')" :active="request()->routeIs('search.form')">
                <x-icons.page-icon /> {{ __('Search') }}
            </x-buttons.side-link-button>

            {{-- settings --}}
            <x-buttons.dropdown-side-link-button :id="__('settings')" :name="__('Setting')"
                :active="request()->routeIs('settings')">
                <x-buttons.side-link-button :id="__('settings')" :collaspe="__('true')" :href="url('settings/cron')"
                    :show="request()->routeIs('settings')" :active="request()->is('settings/cron')">
                    <x-icons.page-icon /> {{ __('Cron') }}
                </x-buttons.side-link-button>

                <x-buttons.side-link-button :id="__('settings')" :collaspe="__('true')" :href="url('settings/vpn')"
                    :show="request()->routeIs('settings')" :active="request()->is('settings/vpn')">
                    <x-icons.page-icon /> {{ __('Vpn') }}
                </x-buttons.side-link-button>

            </x-buttons.dropdown-side-link-button>
        </ul>
    </div>
</nav>
