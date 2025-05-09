<!-- partials/nav-admin.blade.php --> 
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
        <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Accueil</a></li>
        <li><a href="{{ route('profile.admin.show') }}"><i class="fas fa-user"></i> Mon Profil</a></li>
        
        <!-- Menu déroulant pour la gestion des comptes -->
        <li class="has-submenu">
            <a href="#"><i class="fas fa-users"></i> Gestion des comptes <i class="fas fa-chevron-down"></i></a>
            <ul class="submenu">
                <li><a href="{{ route('admin.users.index') }}"><i class="fas fa-list"></i> Tous les comptes</a></li>
                <li><a href="{{ route('admin.users.commercants') }}"><i class="fas fa-store"></i> Commerçants</a></li>
                <li><a href="{{ route('admin.users.consommateurs') }}"><i class="fas fa-user-friends"></i> Consommateurs</a></li>
                <li><a href="{{ route('admin.users.create') }}"><i class="fas fa-plus-circle"></i> Ajouter un compte</a></li>
            </ul>
        </li>
        
        <!-- Nouveau menu pour la gestion des catégories -->
        <li class="has-submenu">
            <a href="#"><i class="fas fa-tags"></i> Catégories <i class="fas fa-chevron-down"></i></a>
            <ul class="submenu">
                <li><a href="{{ route('admin.categories.index') }}"><i class="fas fa-circle"></i> Toutes les catégories</a></li>
                <li><a href="{{ route('admin.categories.create') }}"><i class="fas fa-plus-circle"></i> Ajouter une catégorie</a></li>
            </ul>
        </li>

        <li><a href="{{ route('admin.property.index') }}"><i class="fas fa-box"></i> Gérer les produits</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="menu-logout-button"><i class="fas fa-sign-out-alt"></i> Déconnexion</button>
            </form>
        </li>
    </ul>
</div>

<style>
    .has-submenu .submenu {
        display: none;
        padding-left: 20px;
    }
    
    .has-submenu.active .submenu {
        display: block;
    }
    
    .has-submenu > a {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .menu-nav i {
        margin-right: 8px;
        width: 20px;
        text-align: center;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion du menu déroulant
        const submenus = document.querySelectorAll('.has-submenu > a');
        submenus.forEach(menu => {
            menu.addEventListener('click', function(e) {
                e.preventDefault();
                this.parentElement.classList.toggle('active');
            });
        });
        
        // Activer automatiquement le sous-menu si on est sur une page correspondante
        const currentPath = window.location.pathname;
        if (currentPath.includes('/admin/users')) {
            document.querySelector('.has-submenu').classList.add('active');
        } else if (currentPath.includes('/admin/categories')) {
            document.querySelectorAll('.has-submenu')[1].classList.add('active');
        }
    });
</script>