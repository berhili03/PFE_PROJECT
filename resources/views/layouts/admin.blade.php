<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - @yield('title', 'Tableau de bord')</title>
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    @yield('styles')
</head>
<body>
    <div class="page-layout">
        @php
        // Palettes de couleurs prédéfinies
        $colorPalettes = [
            ['from' => '#3b82f6', 'to' => '#8b5cf6'],  // Bleu -> Violet
            ['from' => '#10b981', 'to' => '#059669'],  // Vert
            ['from' => '#ec4899', 'to' => '#db2777'],  // Rose
            ['from' => '#f59e0b', 'to' => '#d97706'],  // Orange
            ['from' => '#6366f1', 'to' => '#4f46e5']   // Indigo
        ];
        @endphp
        
        <!-- Sidebar -->
        @include('partials.nav-admin')
        
        <!-- Contenu principal -->
        <div class="content">
            @if(session('success'))
                <div id="success-alert" class="custom-alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Animation pour les alertes de succès
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.classList.add('fade-out');
                    setTimeout(function() {
                        successAlert.style.display = 'none';
                    }, 500);
                }, 3000);
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>