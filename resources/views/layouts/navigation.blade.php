<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Accueil') }}
                    </x-nav-link>
                </div>

                @canany(['Admin', 'Super Admin', 'coach'])
                    <!-- Admin Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:relative sm:-my-px sm:ms-10">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="px-1 pt-1 text-sm font-medium text-gray-500 bg-white rounded-md hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                    {{ __('Admin') }}
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @can('manage-users')
                                    <x-dropdown-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                                        {{ __('Utilisateur') }}
                                    </x-dropdown-link>
                                @endcan

                                @can('manage-roles')
                                    <x-dropdown-link :href="route('roles.index')" :active="request()->routeIs('roles.index')">
                                        {{ __('Rôles') }}
                                    </x-dropdown-link>
                                @endcan

                                <x-dropdown-link :href="route('teams.index')" :active="request()->routeIs('teams.index')">
                                    {{ __('Équipes') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endcanany

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('calendar')" :active="request()->routeIs('calendar')">
                        {{ __('Mon agenda') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('chat-room-users')" :active="request()->routeIs('chat-room-users')">
                        {{ __('Messagerie') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('my.teams')" :active="request()->routeIs('my.teams')">
                        {{ __('Mon équipe') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('searchUser.index')" :active="request()->routeIs('searchUser.index')">
                        {{ __('Rechercher') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->firstname }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" :active="request()->routeIs('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div id="menu-hamburger" class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Accueil') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('calendar')" :active="request()->routeIs('calendar')">
                {{ __('Agenda') }}
            </x-responsive-nav-link>
            @canany(['Admin', 'Super Admin'])
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                    {{ __('Utilisateur') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.index')">
                    {{ __('Rôles') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('teams.index')" :active="request()->routeIs('teams.index')">
                    {{ __('Équipes') }}
                </x-responsive-nav-link>
            @endcanany
            <x-responsive-nav-link :href="route('chat-room-users')" :active="request()->routeIs('chat-room-users')">
                {{ __('Messagerie') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('my.teams')" :active="request()->routeIs('my.teams')">
                {{ __('Mon équipe') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->firstname }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Déconnexion') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>


<nav class="bottom-nav-bar sm:hidden block fixed bottom-0 left-0 z-50 w-full h-18 bg-white border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600">
    <div class="h-full max-w-lg mx-auto flex justify-around items-center font-medium">

        <x-nav-link-icon icon="ic:round-home" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Accueil') }}
        </x-nav-link-icon>

        <x-nav-link-icon icon="ion:calendar-outline" :href="route('calendar')" :active="request()->routeIs('calendar')">
            {{ __('Agenda') }}
        </x-nav-link-icon>

        <x-nav-link-icon icon="streamline:chat-two-bubbles-oval-solid" :href="route('chat-room-users')" :active="request()->routeIs('chat-room-users')">
            {{ __('Messagerie') }}
        </x-nav-link-icon>

        <x-nav-link-icon icon="fluent:people-team-24-filled" :href="route('my.teams')" :active="request()->routeIs('my.teams')">
            {{ __('Mon équipe') }}
        </x-nav-link-icon>

    </div>
</nav>

<style>
    @media (min-width: 640px) {
        #menu-hamburger {
            display: none;
        }
    }

    .bottom-nav-bar {
        padding-top: 10px;
        padding-bottom: 10px;
    }
</style>
