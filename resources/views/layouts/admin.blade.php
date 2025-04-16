<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Mon Profil</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    @yield('styles') <!-- permet d'injecter les styles -->
</head>
<body>
    <div class="layout">
        @include('partials.nav-admin') <!-- Sidebar à part (expliqué plus bas) -->
        
        <main class="content">
            @yield('content')
        </main>
    </div>
</body>
</html>
