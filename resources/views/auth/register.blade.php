<!-- Modal d'inscription -->
<div id="registerModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-teal-50 rounded-lg shadow-lg max-w-md w-full p-6 relative">
        <!-- Bouton de fermeture -->
        <button onclick="closeRegister()" class="absolute top-2 right-2 text-gray-600 hover:text-red-500 text-xl font-bold">×</button>

        <h2 class="text-2xl font-semibold mb-4">S'inscrire</h2>

        <!-- Affichage des erreurs de validation -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nom Complet')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Date de Naissance -->
            <div class="mt-4">
                <x-input-label for="dateNaissance" :value="__('Date de Naissance')" />
                <x-text-input id="dateNaissance" class="block mt-1 w-full" type="date" name="dateNaissance" :value="old('dateNaissance')" required autocomplete="birthdate" />
                <x-input-error :messages="$errors->get('dateNaissance')" class="mt-2" />
            </div>

            <!-- Genre et Rôle -->
            <div class="mt-4">
                <div class="flex">
                    <div class="mr-2">
                        <x-input-label for="sexe" :value="__('Genre')" />
                        <select id="sexe" name="sexe" class="block mt-1 w-full" :value="old('sexe')" required>
                            <option value="" disabled {{ old('sexe') == '' ? 'selected' : '' }}>{{ __('Sélectionnez un genre') }}</option>
                            <option value="Homme" {{ old('sexe') == 'Homme' ? 'selected' : '' }}>{{ __('Homme') }}</option>
                            <option value="Femme" {{ old('sexe') == 'Femme' ? 'selected' : '' }}>{{ __('Femme') }}</option>
                        </select>
                    </div>
                    <div>
                        <x-input-label for="role" :value="__('Rôle')" />
                        <select id="role" name="role" class="block mt-1 w-full" :value="old('role')" required>
                            <option value="" disabled {{ old('role') == '' ? 'selected' : '' }}>{{ __('Sélectionnez un rôle') }}</option>
                            <option value="Consommateur" {{ old('role') == 'Consommateur' ? 'selected' : '' }}>{{ __('Consommateur') }}</option>
                            <option value="Commercant" {{ old('role') == 'Commercant' ? 'selected' : '' }}>{{ __('Commercant') }}</option>
                        </select>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('sexe')" class="mt-2" />
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <!-- Téléphone -->
            <div class="mt-4">
                <x-input-label for="tel" :value="__('Téléphone')" />
                <x-text-input id="tel" class="block mt-1 w-full" type="tel" name="tel" :value="old('tel')" required autocomplete="tel" />
                <x-input-error :messages="$errors->get('tel')" class="mt-2" />
            </div>

            <!-- Adresse -->
            <div class="mt-4">
                <x-input-label for="adresse" :value="__('Adresse')" />
                <textarea id="adresse" class="block mt-1 w-full" name="adresse" required autocomplete="address" rows="1">{{ old('adresse') }}</textarea>
                <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Mot de passe')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmer ')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>

    </div>
</div>
