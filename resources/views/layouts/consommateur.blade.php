<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Consommateur- Mon Profil</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    @yield('styles') <!-- permet d'injecter les styles -->
</head>
<body>
    <div class="layout">
        @include('partials.nav-consommateur') <!-- Sidebar à part (expliqué plus bas) -->
        
        <main class="content">
            @yield('content')
        </main>
    </div>
</body>
</html>
