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
    @include('auth.login')
</div>

<!-- Register Form -->
<div id="registerForm" class="hidden p-6 rounded shadow-lg w-full max-w-2xl overflow-y-auto max-h-[80vh]">
    <h2 class="text-xl font-semibold mb-4"></h2>
    @include('auth.register')
</div>

</div>

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

</body>
</html>
