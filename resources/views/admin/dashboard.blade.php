@extends('layouts.admin')

@section('content')
<div class="admin-dashboard-container">
        <h1 class="admin-dashboard-title" id="adminWelcomeTitle">Bienvenue Admin 👑</h1>
        
        <div class="admin-stats-grid">
            <!-- Vos cartes statistiques ici -->
        </div>
    </div>
        
        <div class="admin-stats-grid">
            <div class="admin-stat-card admin-stat-merchants">
                <p class="admin-stat-label">Commerçants</p>
                <p class="admin-stat-value">{{ $commercantCount }} inscrits</p>

            </div> <div class="admin-stat-card admin-stat-users">
                <p class="admin-stat-label">Consommateurs</p>
                <p class="admin-stat-value">{{ $consommateurCount }} inscrits</p>
            </div>
            <div class="admin-stat-card admin-stat-products">
                <p class="admin-stat-label">Produits</p>
                <p class="admin-stat-value">{{ $produitCount }} disponibles</p>
            </div>
            <div class="admin-stat-card admin-stat-growth">
                <p class="admin-stat-label">Statistiques</p>
                <p class="admin-stat-value">+5% croissance</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const welcomeTitle = document.getElementById('adminWelcomeTitle');
            const hour = new Date().getHours();
            let greeting;
            
            if (hour < 18 && hour > 4) {
                greeting = "Bonjour Admin ☀️";
            }  else {
                greeting = "Bonsoir Admin 🌙";
            }
            
            welcomeTitle.textContent = greeting;
        });
    </script>
@endsection
