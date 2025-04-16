@extends('layouts.consommateur')

@section('content')
<div class="admin-dashboard-container">
        <h1 class="admin-dashboard-title" id="consommateurWelcomeTitle">Bienvenue consommateur </h1>
        
        <div class="admin-stats-grid">
            <!-- Vos cartes statistiques ici -->
        </div>
    </div>
  
            <div class="admin-stat-card admin-stat-growth">
                <p class="admin-stat-label">Statistiques</p>
                <p class="admin-stat-value">+5% croissance</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const welcomeTitle = document.getElementById('consommateurWelcomeTitle');
            const hour = new Date().getHours();
            let greeting;
            
            if (hour < 18 && hour > 4) {
                greeting = "Bonjour consommateur ";
            }  else {
                greeting = "Bonsoir consommateur ";
            }
            
            welcomeTitle.textContent = greeting;
        });
    </script>
@endsection
