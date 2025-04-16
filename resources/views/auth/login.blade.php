<!-- Modale de connexion pleine page avec fond sombre transparent -->
<div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    
    <!-- Conteneur de la boîte de dialogue de connexion -->
    <div class="bg-teal-50 rounded-lg shadow-lg max-w-md w-full p-6 relative">
        
        <!-- Bouton de fermeture "×", placé en haut à droite -->
        <button onclick="closeLogin()" class="absolute top-2 right-2 text-gray-600 hover:text-red-500 text-2xl font-bold">×</button>

        <!-- Titre de la modale -->
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Se connecter</h2>

        <!-- Affichage des erreurs de validation si elles existent -->
        @if ($errors->any())
            <div class="alert alert-danger bg-red-100 text-red-600 p-4 rounded-lg mb-4">
                <ul>
                    <!-- Parcours de toutes les erreurs et affichage de chacune dans une <li> -->
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire de connexion -->
        <form method="POST" action="{{ route('login') }}">
            @csrf <!-- Protection CSRF (obligatoire dans les formulaires Laravel) -->

            <!-- Champ Email -->
            <div>
                <!-- Label du champ -->
                <x-input-label for="email" :value="__('Email')" />
                <!-- Champ de saisie -->
             <x-text-input
                id="email"
                name="email"
                type="email"
                :value="old('email')"
                class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                required
                autofocus
                autocomplete="email"
            />

                <!-- Message d'erreur pour le champ email -->
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Champ Mot de passe -->
            <div class="mt-4">
                <!-- Label du champ -->
                <x-input-label for="password" :value="__('Mot de passe')" />
                <!-- Champ de saisie du mot de passe -->
                <x-text-input
                    id="password"
                    class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                />
                <!-- Message d'erreur pour le mot de passe -->
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Case à cocher "Se souvenir de moi" -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring focus:ring-indigo-500" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('remember_me') }}</span>
                </label>
            </div>

            <!-- Liens et bouton de soumission -->
            <div class="flex items-center justify-between mt-6">
                <!-- Lien vers la page "Mot de passe oublié" s'il existe -->
                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">
                        {{ __('Mot de passe oublié ?') }}
                    </a>
                @endif

                <!-- Bouton "Se connecter" stylisé avec composants Laravel -->
                <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 px-6 py-2 rounded-full text-white">
                    {{ __('Se connecter') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
