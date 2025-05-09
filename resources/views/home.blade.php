<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        /* Style personnalisé pour la modale de login */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
        }
        
        .modal.hidden {
            display: none;
        }
        
        .modal-content {
            background: white;
            border-radius: 15px;
            width: 90%;
            max-width: 420px;
            padding: 25px;
            position: relative;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 22px;
            background: #f8f9fa;
            color: #4a5568;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .close-btn:hover {
            background: #e2e8f0;
            transform: rotate(90deg);
        }
        
        .modal-title {
            text-align: center;
            margin-bottom: 25px;
            color: #2d3748;
            font-weight: 600;
            position: relative;
            padding-bottom: 10px;
        }
        
        .modal-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: linear-gradient(to right, #38b2ac, #4299e1);
        }
        
        .error-box {
            background: #fff5f5;
            color: #c53030;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
            border-left: 4px solid #fc8181;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #4a5568;
            font-weight: 500;
        }
        
        .form-input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
            background-color: #f8fafc;
        }
        
        .form-input:focus {
            border-color: #4299e1;
            box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.2);
            outline: none;
            background-color: #fff;
        }
        
        .input-error {
            color: #e53e3e;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            margin-right: 8px;
            accent-color: #4299e1;
        }
        
        .remember-me label {
            font-size: 14px;
            color: #4a5568;
        }
        
        .forgot-link {
            font-size: 14px;
            color: #4299e1;
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .forgot-link:hover {
            color: #2b6cb0;
            text-decoration: underline;
        }
        
        .submit-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #38b2ac, #4299e1);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(66, 153, 225, 0.3);
        }
        
        .submit-btn:active {
            transform: translateY(0);
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #718096;
        }
        
        .register-link a {
            color: #4299e1;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        
        .register-link a:hover {
            color: #2b6cb0;
            text-decoration: underline;
        }
    </style>
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
            <!-- Login Modal (votre style CSS) -->
            <div id="loginModal" class="modal hidden">
                <div class="modal-content">
                    <button onclick="closeLogin()" class="close-btn">&times;</button>
                    <h2 class="modal-title">Se connecter</h2>
                    
                    @if ($errors->any())
                    <div class="error-box">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <form method="POST" action="{{ route('login') }}" class="form">
                        @csrf
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" 
                                   class="form-input" required autofocus placeholder="Votre adresse email">
                            @error('email')
                                <span class="input-error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" id="password" name="password" 
                                   class="form-input" required placeholder="Votre mot de passe">
                            @error('password')
                                <span class="input-error">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="remember-forgot">
                            <div class="remember-me">
                                <input id="remember_me" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember_me">Se souvenir de moi</label>
                            </div>
                            
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-link">Mot de passe oublié ?</a>
                            @endif
                        </div>
                        
                        <button type="submit" class="submit-btn">Se connecter</button>
                        
                        <p class="register-link">Pas encore membre ? <a href="#" onclick="showForm('register')">Créer un compte</a></p>
                    </form>
                </div>
            </div>

            <!-- Register Form (style Tailwind) -->
            <div id="registerForm" class="hidden p-6 rounded shadow-lg w-full max-w-2xl overflow-y-auto max-h-[80vh]">
                @include('auth.register')
            </div>
        </div>
    </div>

    <script>
        function showForm(form) {
            // Cacher tous les formulaires
            document.getElementById('loginModal').classList.add('hidden');
            document.getElementById('registerForm').classList.add('hidden');

            if (form === 'login') {
                document.getElementById('loginModal').classList.remove('hidden');
            } else if (form === 'register') {
                document.getElementById('registerForm').classList.remove('hidden');
            }
        }

        function closeLogin() {
            document.getElementById('loginModal').classList.add('hidden');
        }

        function closeRegister() {
            document.getElementById('registerForm').classList.add('hidden');
        }

        // Afficher automatiquement le login si erreurs
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('loginModal').classList.remove('hidden');
            });
        @endif
    </script>
</body>
</html>