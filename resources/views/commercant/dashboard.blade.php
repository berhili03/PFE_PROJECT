@extends('layouts.commercant')

@section('content')
<div class="commercant-dashboard-container">
        <h1 class="commercant-dashboard-title" id="commercantWelcomeTitle">Bienvenue commercant </h1>
        
        <div class="commercant-stats-grid">
            <!-- Vos cartes statistiques ici -->
        </div>
    </div>
  
            <div class="commercant-stat-card commercant-stat-growth">
                <p class="commercant-stat-label">Statistiques</p>
                <p class="commercant-stat-value">+5% croissance</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const welcomeTitle = document.getElementById('commercantWelcomeTitle');
            const hour = new Date().getHours();
            let greeting;
            
            if (hour < 18 && hour > 4) {
                greeting = "Bonjour commerçant ";
            }  else {
                greeting = "Bonsoir commerçant ";
            }
            
            welcomeTitle.textContent = greeting;
        });
    </script>
@endsection
