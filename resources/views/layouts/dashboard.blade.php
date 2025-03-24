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
                    <x-nav-link wire:navigate icon="bi-key-fill" :href="route('dashboard.permissions')" :label="__('Permissions')"
                        :active="request()->routeIs(['dashboard.permissions', 'dashboard.permissions.*'])" />
                </nav>
            </div>
        </div>
        <main class="lg:ps-64 min-h-75vh relative">
            <div class="navbar h-14 bg-gray-100 dark:bg-gray-700 sticky top-0">
                <div class="nav">
                  <button class="navbar-brand nav-link md:hidden offcanvas-toggle" data-fg-toggle="offcanvas" data-fg-target="#dashboard-sidebar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                    </svg>
                  </button>
                    <div class="form-control-container hidden ms-3 sm:flex">
                        <input type="search" class="form-control xs pill has-end-icon">
                        <span class="end-icon">
                            <i class="icon bi-search"></i>
                        </span>
                    </div>
                    <button type="button" class="nav-link ms-3 sm:hidden">
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
            
            <div class="container px-2 lg:px-4 py-4">
                <div class="md:flex-space-2 justify-between">
                    <h3 class="text-gray-500 dark:text-white text-2xl">{{ $title }}</h3>
                    @if (isset($actions))
                      <div class="flex-space-2 mb-3 md:mb-0">
                        {{ $actions }}
                      </div>
                    @endif
                </div>

                {{ $slot }}
            </div>

        </main>
    </div>
</x-app-layout>