<div class="menu-sidebar">
    <div class="menu-header">
   
    @php
        // Palettes de couleurs prédéfinies
        $colorPalettes = [
            ['from' => '#3b82f6', 'to' => '#8b5cf6'],  // Bleu -> Violet
            ['from' => '#10b981', 'to' => '#059669'],  // Vert
            ['from' => '#ec4899', 'to' => '#db2777'],  // Rose
            ['from' => '#f59e0b', 'to' => '#d97706'],  // Orange
            ['from' => '#6366f1', 'to' => '#4f46e5']   // Indigo
        ];
        
        // Sélection aléatoire stable basée sur le nom
        $palette = $colorPalettes[crc32(Auth::user()->name) % count($colorPalettes)];
    @endphp

    <div class="admin-avatar" style="background: linear-gradient(135deg, {{ $palette['from'] }}, {{ $palette['to'] }})">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
    </div>
    <p class="menu-username">{{ Auth::user()->name }}</p>
</div>
    <ul class="menu-nav">
        <li><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
        <li><a href="{{ route('profile.admin.show') }}">Afficher Profil</a></li>
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