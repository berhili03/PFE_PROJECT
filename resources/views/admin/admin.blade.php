<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <title>@yield('nom_Produit') | Administration </title>
</head>
<body>
    <div class="page-layout">
        <div class="menu-sidebar">
            <div class="menu-header">
                <img src="/path/to/avatar.svg" class="menu-avatar" />
                <p class="menu-username">{{ Auth::user()->name }}</p>
            </div>
            <ul class="menu-nav">
                <li><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
                <li><a href="{{ route('profile.show') }}">Afficher Profil</a></li>
                <li><a href="#">Gérer les comptes</a></li>
                <li><a href="{{ route('admin.property.index') }}">Gérer les produits</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="menu-logout-button">Déconnexion</button>
                    </form>
                </li>
            </ul>
        </div>
        
        <!-- Contenu Principal -->
        <div class="content">
            <div class="container mt-5">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                alert.style.opacity = 0;
                setTimeout(() => alert.remove(), 1000);
            }
        }, 4000);
    </script>
</body>
</html>