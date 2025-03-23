<x-app-layout :title="$title ?? ''">
    <div class="min-h-screen">
        <div class="offcanvas offcanvas-start offcanvas-primary expand-lg dashboard-sidebar" id="dashboard-sidebar">
            <div class="offcanvas-header flex-space-2 items-center h-14">
                <x-app-logo />
                <button class="btn offcanvas-close lg:hidden">
                    <i class="icon bi-x"></i>
                </button>
            </div>
            <div class="offcanvas-body">
                <nav class="nav vertical">
                    <x-nav-link wire:navigate icon="bi-speedometer" :href="route('dashboard')" :label="__('Dashboard')"
                        :active="request()->routeIs(['dashboard'])" />
                    <x-nav-link wire:navigate icon="bi-person-gear" :href="route('dashboard.profile')" :label="__('Profile')"
                        :active="request()->routeIs('dashboard.profile')" />
                    <x-nav-link wire:navigate icon="bi-people-fill" :href="route('dashboard.users')" :label="__('Users')"
                        :active="request()->routeIs(['dashboard.users', 'dashboard.users.*'])" />
                    <x-nav-link wire:navigate icon="bi-person-fill-lock" :href="route('dashboard.roles')" :label="__('Roles')"
                        :active="request()->routeIs(['dashboard.roles', 'dashboard.roles.*'])" />
                </nav>
            </div>
        </div>
        <main class="lg:ps-64 min-h-75vh relative">
            <div class="navbar h-14 bg-gray-100 dark:bg-gray-700 sticky top-0">
                <button class="nav-link md:hidden">
                    <i class="bi-list"></i>
                </button>
                <div class="nav">
                    <div class="form-control-container hidden sm:flex">
                        <input type="search" class="form-control xs pill has-end-icon">
                        <span class="end-icon">
                            <i class="icon bi-search"></i>
                        </span>
                    </div>
                    <button type="button" class="nav-link sm:hidden">
                        @icon('bi-search')
                    </button>
                </div>
                <div class="nav">
                    <button type="button" class="nav-link dark-mode-toggle">
                    </button>
                    <div class="dropdown">
                        <button type="button" class="nav-link dropdown-toggle">
                            @guest
                                <i class="icon bi-person-fill"></i>
                            @endguest
                            @auth
                                <span>{{ auth()->user()->name }}</span>
                            @endauth
                            <i class="icon bi-chevron-down w-3 h-3"></i>
                        </button>
                        <div class="dropdown-menu dropdown-end w-40">
                            @guest
                                <a href="{{ route('login') }}" class="dropdown-link">
                                    <i class="icon bi-box-arrow-in-right"></i>
                                    <span>{{ __('Sign in') }}</span>
                                </a>
                                <a href="{{ route('register') }}" class="dropdown-link">
                                    <i class="icon bi-person-plus"></i>
                                    <span>{{ __('Sign up') }}</span>
                                </a>
                            @endguest
                            @auth
                                <a href="{{ route('dashboard') }}" class="dropdown-link">
                                    <i class="icon bi-speedometer"></i>
                                    <span>{{ __('Dashboard') }}</span>
                                </a>
                                <a href="{{ route('dashboard.profile') }}" class="dropdown-link">
                                    <i class="icon bi-person-gear"></i>
                                    <span>{{ __('Profile') }}</span>
                                </a>
                                <a href="{{ route('logout') }}" class="dropdown-link">
                                    <i class="icon bi-box-arrow-right"></i>
                                    <span>{{ __('Logout') }}</span>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:px-4 py-4">
                <div class="md:flex-space-2 justify-between">
                    <h3 class="text-gray-500 dark:text-white text-2xl">{{ $title }}</h3>
                    @if (isset($actions))
                        {{ $actions }}
                    @endif
                </div>

                {{ $slot }}
            </div>

        </main>
    </div>
</x-app-layout>
