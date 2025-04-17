<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="m-0 p-0 overflow-hidden">
    <div class="relative h-screen w-screen bg-cover bg-center" style="background-image: url('/images/background.jpeg');">

        <!-- Header Fixe -->
        <header class="fixed top-0 left-0 w-full bg-black bg-opacity-60 text-white flex justify-between items-center px-8 py-4 z-50">
            <h1 class="text-xl font-bold"></h1>
            <div class="space-x-4">
                <button onclick="showForm('login')" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-full text-lg font-semibold hover:from-indigo-600 hover:to-blue-500 transition duration-300">Se connecter</button>
                <button onclick="showForm('register')" class="bg-gradient-to-r from-green-500 to-teal-600 text-white px-6 py-3 rounded-full text-lg font-semibold hover:from-teal-600 hover:to-green-500 transition duration-300">S'inscrire</button>
            </div>
        </header>

        <!-- Footer Fixe -->
        <footer class="fixed bottom-0 left-0 w-full bg-black bg-opacity-60 text-white text-center py-3 z-50">
            &copy; {{ date('Y') }} FromWhere. Made by Fatima-Zahra BERHILI && Soukayna ABDELKHALQUI.
        </footer>

        <!-- Formulaires -->
        <div class="absolute inset-0 flex items-center justify-center z-40">
            <!-- Login Form -->
            <div id="loginForm" class="hidden p-6 rounded shadow-lg w-full max-w-2xl overflow-y-auto max-h-[80vh]">
                <!-- Modale de connexion -->
                <div class="bg-teal-50 rounded-lg shadow-lg max-w-md w-full p-6 relative">
                    <!-- Bouton de fermeture -->
                    <button onclick="closeLogin()" class="absolute top-2 right-2 text-gray-600 hover:text-red-500 text-2xl font-bold">×</button>

                    <!-- Titre -->
                    <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Se connecter</h2>

                    <!-- Erreurs -->
                    @if ($errors->any())
                        <div class="alert alert-danger bg-red-100 text-red-600 p-4 rounded-lg mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Formulaire -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
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
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Mot de passe -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Mot de passe')" />
                            <x-text-input
                                id="password"
                                class="block mt-1 w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Se souvenir de moi -->
                        <div class="block mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring focus:ring-indigo-500" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <!-- Liens et bouton -->
                        <div class="flex items-center justify-between mt-6">
                            @if (Route::has('password.request'))
                                <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">
                                    {{ __('Mot de passe oublié ?') }}
                                </a>
                            @endif

                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 px-6 py-2 rounded-full text-white">
                                {{ __('Se connecter') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Register Form -->
            <div id="registerForm" class="hidden p-6 rounded shadow-lg w-full max-w-2xl overflow-y-auto max-h-[80vh]">
                <h2 class="text-xl font-semibold mb-4"></h2>
                @include('auth.register')
            </div>
        </div>
    </div>

    <!-- Script principal -->
    <script>
        function showForm(form) {
            document.getElementById('loginForm').classList.add('hidden');
            document.getElementById('registerForm').classList.add('hidden');

            if (form === 'login') {
                document.getElementById('loginForm').classList.remove('hidden');
            } else if (form === 'register') {
                document.getElementById('registerForm').classList.remove('hidden');
            }
        }

        function closeLogin() {
            document.getElementById('loginForm').classList.add('hidden');
        }

        function closeRegister() {
            document.getElementById('registerForm').classList.add('hidden');
        }
    </script>

    <!-- Affichage automatique de la modale login en cas d'erreur -->
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('loginForm').classList.remove('hidden');
                document.getElementById('registerForm').classList.add('hidden');
            });
        </script>
    @endif
</body>
</html>
