<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse" style="">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <x-buttons.side-link-button :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <x-icons.home-icon />
                {{ __('Dashboard') }}
            </x-buttons.side-link-button>

            {{-- Toggle Dropdown --}}
            {{-- <x-buttons.dropdown-side-link-button :id="__('sites')" :name="__('Websites')"
                :active="request()->routeIs('scrapper.*')">
                <x-slot name="icon">
                    <x-icons.website-icon />
                </x-slot>
                <x-buttons.side-link-button :id="__('sites')" :collaspe="__('true')"
                    :href="route('scrapper.index', ['filter[site_name]' => 'bayt'])"
                    :show="request()->routeIs('scrapper.*')" :active="request()->routeIs('scrapper.index')">
                    <x-icons.circle-icon /> {{ __('Bayt Jobs') }}
            </x-buttons.side-link-button>

            <x-buttons.side-link-button :id="__('sites')" :collaspe="__('true')"
                :href="route('scrapper.index', ['filter[site_name]' => 'jobbank'])"
                :show="request()->routeIs('scrapper.*')" :active="request()->routeIs('scrapper.index')">
                <x-icons.circle-icon /> {{ __('JobBank Jobs') }}
            </x-buttons.side-link-button>

            <x-buttons.side-link-button :id="__('sites')" :collaspe="__('true')"
                :href="route('scrapper.index', ['filter[site_name]' => 'linkedin'])"
                :show="request()->routeIs('scrapper.*')" :active="request()->routeIs('scrapper.index')">
                <x-icons.circle-icon /> {{ __('LinkedIn Jobs') }}
            </x-buttons.side-link-button>

            <x-buttons.side-link-button :id="__('sites')" :collaspe="__('true')" :href="route('scrapper.index')"
                :show="request()->routeIs('scrapper.*')" :active="request()->routeIs('scrapper.index')">
                <x-icons.circle-icon /> {{ __('All Jobs') }}
            </x-buttons.side-link-button>

            <x-buttons.side-link-button :id="__('sites')" :collaspe="__('true')" :href="route('scrapper.import')"
                :show="request()->routeIs('scrapper.*')" :active="request()->routeIs('scrapper.import')">
                <x-icons.circle-icon /> {{ __('Import Jobs using csv') }}
            </x-buttons.side-link-button>
            </x-buttons.dropdown-side-link-button> --}}

            <x-buttons.side-link-button :href="route('scrapper.site')" :active="request()->routeIs('scrapper.site')">
                <x-icons.website-icon /> {{ __('Websites') }}
            </x-buttons.side-link-button>

            <x-buttons.side-link-button :href="route('company.index')" :active="request()->routeIs('company.index')">
                <x-icons.company-icon /> {{ __('Companies') }}
            </x-buttons.side-link-button>

            <x-buttons.side-link-button :href="route('scrapper.import')"
                :active="request()->routeIs('scrapper.import')">
                <x-icons.page-icon /> {{ __('Import Jobs using csv') }}
            </x-buttons.side-link-button>

            <x-buttons.side-link-button :href="route('reports')" :active="request()->routeIs('reports')">
                <x-icons.report-icon /> {{ __('Reports') }}
            </x-buttons.side-link-button>

            <x-buttons.dropdown-side-link-button :id="__('search')" :name="__('Search')"
                :active="request()->routeIs('search.form')">

                <x-slot name="icon">
                    <x-icons.search-icon />
                </x-slot>
                
                <x-buttons.side-link-button :id="__('search')" :collaspe="__('true')" :href="route('search.form')"
                    :show="request()->routeIs('search.form')" :active="request()->is('search?by=search')">
                    <x-icons.circle-icon /> {{ __('Search') }}
                </x-buttons.side-link-button>

                <x-buttons.side-link-button :id="__('search')" :collaspe="__('true')" :href="route('search.form', ['by' => 'keyword'])"
                    :show="request()->routeIs('search.form')" :active="request()->is('search?by=keyword')">
                    <x-icons.circle-icon /> {{ __('Search By Keyword') }}
                </x-buttons.side-link-button>

            </x-buttons.dropdown-side-link-button>

            {{-- settings --}}
            <x-buttons.dropdown-side-link-button :id="__('settings')" :name="__('Setting')"
                :active="request()->routeIs('settings')">

                <x-slot name="icon">
                    <x-icons.setting-icon />
                </x-slot>

                <x-buttons.side-link-button :id="__('settings')" :collaspe="__('true')" :href="url('settings/cron')"
                    :show="request()->routeIs('settings')" :active="request()->is('settings/cron')">
                    <x-icons.circle-icon /> {{ __('Cron') }}
                </x-buttons.side-link-button>

                <x-buttons.side-link-button :id="__('settings')" :collaspe="__('true')" :href="url('settings/vpn')"
                    :show="request()->routeIs('settings')" :active="request()->is('settings/vpn')">
                    <x-icons.circle-icon /> {{ __('Vpn') }}
                </x-buttons.side-link-button>

                <x-buttons.side-link-button :id="__('settings')" :collaspe="__('true')" :href="url('stats')"
                    :show="request()->routeIs('settings')" :active="request()->is('stats')">
                    <x-icons.circle-icon /> {{ __('Stats') }}
                </x-buttons.side-link-button>

            </x-buttons.dropdown-side-link-button>
        </ul>
    </div>
</nav>
