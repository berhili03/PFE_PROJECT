<!-- Début de la balise de navigation -->
<nav x-data="{ open: false }" class="bg-white dark:bg-teal-100  border-b border-gray-100 dark:border-gray-700">
    <!-- Alpine.js gère ici l'état du menu responsive "open" -->

    <!-- Conteneur principal centré avec un padding responsive -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Flex container pour aligner le logo à gauche et les boutons à droite -->
        <div class="flex justify-between h-16">
            
            <!-- Partie gauche : logo + liens de navigation -->
            <div class="flex">

                <!-- Logo de l'application -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <!-- Composant Blade pour afficher le logo -->
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Liens de navigation (comme "Dashboard") -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- Lien actif si la route actuelle est "dashboard" -->
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Partie droite : menu utilisateur (nom, profil, déconnexion) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Dropdown personnalisé (composant Blade) -->
                <x-dropdown align="right" width="48">

                    <!-- Déclencheur du dropdown : le nom de l'utilisateur -->
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 ...">
                            <div>{{ Auth::user()->name }}</div>

                            <!-- Flèche du menu déroulant -->
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" ...>
                                    <path ... />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <!-- Contenu du dropdown -->
                    <x-slot name="content">
                        <!-- Lien vers le profil -->
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Lien de déconnexion (dans un formulaire pour POST) -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>

                </x-dropdown>
            </div>

            <!-- Menu hamburger pour les écrans petits (mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center ...">
                    <!-- Icône burger -->
                    <svg class="h-6 w-6" ...>
                        <!-- Icone ouverte -->
                        <path :class="{'hidden': open, 'inline-flex': ! open }" ... d="M4 6h16M4 12h16M4 18h16" />
                        <!-- Icone fermée (croix) -->
                        <path :class="{'hidden': ! open, 'inline-flex': open }" ... d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div> <!-- fin flex justify-between -->

    </div> <!-- fin container principal -->

    <!-- Menu responsive (affiché seulement sur petit écran quand "open" = true) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <!-- Liens de navigation en version responsive -->
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Informations utilisateur + liens dans la version responsive -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <!-- Nom -->
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                    {{ Auth::user()->name }}
                </div>
                <!-- Email -->
                <div class="font-medium text-sm text-gray-500">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <!-- Liens vers profil et logout en mobile -->
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Déconnexion en version responsive -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

</nav>
